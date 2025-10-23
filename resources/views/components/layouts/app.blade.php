<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{ $title ?? 'Go Bong Delivery' }}</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <link href="{{ url('website/assets/logo/logo2.jpg') }}" rel="icon" style="border-radius: 50%">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ URL::to('website/assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ URL::to('website/assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ URL::to('website/assets/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ URL::to('website/assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::to('website/assets/css/customStyle.css') }}" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->
        <!-- =========================Header=========================== -->
        <livewire:website.header />

        {{ $slot }}




    <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer">
            <div class="container">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h1 class="text-primary mb-0">Go Bong Delivery</h1>
                                <p class="text-secondary mb-0">{{ __('message.Delicious foods') }}</p>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative mx-auto">
                                <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" placeholder="{{ __('message.Enter email') }}">
                                <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">{{ __('message.Subscribe Now') }}</button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">{{ __('message.Why People Like us') }}!</h4>
                            <p class="mb-4">{{ __('message.We always provide 100% customer satisfaction and absolute quality without any compromise') }}.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Go Bong {{ __('message.Info') }}</h4>
                            <a class="btn-link" href="">{{ __('message.About Us') }}</a>
                            <a class="btn-link" href="">{{ __('message.Contacts') }}</a>
                            <a class="btn-link" href="">{{ __('message.Info') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">{{ __('message.Account') }}</h4>
                            <a class="btn-link" href="">{{ __('message.My Account') }}</a>
                            <a class="btn-link" href="">{{ __('message.My Order') }}</a>
                             <a class="btn-link" href="">{{ __('message.Terms & Condition') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">{{ __('message.Contacts') }}</h4>
                            <p>{{ __('message.Address') }}: Beer City Poipet Zone 3</p>
                            <p>{{ __('message.Email') }}: gobongdelivery@gmail.com</p>
                            <p>{{ __('message.Phone Number') }}: +(855) 69861400</p>
                            {{-- <p>Payment Accepted</p>
                            <img src="{{ URL::to('website/assets/img/payment.png') }}" class="img-fluid" alt=""> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>GoBondDelivery.com</a>, {{ __('message.All Rights Reserved') }}.</span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        {{ __('message.Designed By') }} <a class="border-bottom" href="#">ZaffranTech</a> 
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::to('website/assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ URL::to('website/assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ URL::to('website/assets/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ URL::to('website/assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ URL::to('website/assets/js/main.js') }}"></script>
    </body>

</html>

