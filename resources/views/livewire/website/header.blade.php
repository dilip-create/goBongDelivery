<div>
    <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Beer City Poipet Zone 3</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">contact.gobongdelivery@gmail.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">{{ __('message.Privacy Policy') }}</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">{{ __('message.Terms of Use') }}</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">{{ __('message.Sales and Refunds') }}</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.html" class="navbar-brand"><h1 class="text-primary display-6">Go Bong Delivery</h1></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="/" class="nav-item nav-link active">{{ __('message.Home') }}</a>
                            {{-- <a href="#" class="nav-item nav-link">Promotion</a> --}}
                            <a href="#" class="nav-item nav-link">{{ __('message.Account') }}</a>
                            <a href="shop-detail.html" class="nav-item nav-link">{{ __('message.My Order') }}</a>
                            {{-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="cart.html" class="dropdown-item">Cart</a>
                                    <a href="chackout.html" class="dropdown-item">Chackout</a>
                                    <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                    <a href="404.html" class="dropdown-item">404 Page</a>
                                </div>
                            </div> --}}
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                        @if(session()->get('locale') == 'th-TH')
                                       <img src="{{ url('website/assets/flags/th.png') }}" alt="th-TH" height="23px" width="35px" class="flag-css">
                                        @elseif(session()->get('locale') == 'km')
                                        <img src="{{ url('website/assets/flags/kh.png') }}" alt="km" height="23px" width="35px" class="flag-css">
                                        @elseif(session()->get('locale') == 'en')
                                        <img src="{{ url('website/assets/flags/en.png') }}" alt="en" height="23px" width="35px" class="flag-css">
                                        @else
                                        {{ __('message.Language') }}
                                        @endif
                                </a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                   
                                        @forelse($languages as $language)
                                            <a href="{{ route('change.lang', ['lang' => $language->code]) }}" class="dropdown-item">
                                                <img src="{{ asset('storage/'.$language->icon) }}" alt="en" height="23px" width="35px" class="flag-css">
                                                <span>{{ $language->name }}</span> 
                                            </a>
                                        @empty
                                            <a href="{{ route('change.lang', ['lang' => 'en']) }}" class="dropdown-item">English</a>
                                        @endforelse

                                </div>
                            </div>
                            <a href="#" class="nav-item nav-link">{{ __('message.Logout') }}</a>
                            {{-- <a href="#" class="nav-item nav-link">Login</a> --}}
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                            <a href="#" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                            </a>
                            <a href="#" class="my-auto">
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->
         <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('message.Find a product store') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="{{ __('message.Search here') }}..." aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->
</div>
