<script>
//   import { Link, Head } from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3'
const page = usePage()
const  props  = usePage()
</script>

<template>
<div>
    <!-- You can include <HeaderComponent /> here later -->
    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Beer City Poipet Zone 3</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">contact.gobongdelivery@gmail.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-white"><small class="text-white mx-2">{{ $page.props.translations.Privacy_Policy  }}</small>/</a>
                    <a href="#" class="text-white"><small class="text-white mx-2">{{ $page.props.translations.Terms_of_Use  }}</small>/</a>
                    <a href="#" class="text-white"><small class="text-white ms-2">{{ $page.props.translations.Sales_and_Refunds  }}</small></a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.html" class="navbar-brand">
                    <h1 class="text-primary display-6">Go Bong Delivery</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                       
                        <Link :href="route('/')" :class="{'active' : $page.component === 'Web/Home'}" class="nav-item nav-link">{{ $page.props.translations.Home  }}</Link>
                        
                        
                            <Link v-if="$page.props.auth.customer" :href="route('/')" :class="{'active' : $page.component === 'Web/Home'}" class="nav-item nav-link">{{ $page.props.translations.Account  }}</Link>
                          

                     
                           
                            <Link v-if="$page.props.auth.customer" :href="route('customerlogout')" class="nav-item nav-link">Logout {{ $page.props.auth.customer.id }}</Link> 
                     
                    
                        <div v-else>
                           <Link :href="route('customerLogin')" :class="{'active' : $page.component === 'Web/Auth/customerLogin'}" class="nav-item nav-link">{{ $page.props.translations.Login  }}</Link>
                        </div>


                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img v-if="$page.props.locale === 'th-TH'" :src="`${$page.props.appUrl}/website/assets/flags/th.png`" alt="th-TH" height="23" width="35" class="flag-css me-2" />
                                <img v-else-if="$page.props.locale === 'km'" :src="`${$page.props.appUrl}/website/assets/flags/kh.png`" alt="km" height="23" width="35" class="flag-css me-2" />
                                <img v-else :src="`${$page.props.appUrl}/website/assets/flags/en.png`" alt="en" height="23" width="35" class="flag-css me-2" />
                                </a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <Link v-for="lang in $page.props.languages" :href="route('change.lang', { lang: lang.code })" class="dropdown-item">
                                    <img :src="`/storage/${lang.icon}`" :alt="lang.code" height="23" width="35" class="flag-css me-2" /> {{ lang.name }}
                                    </Link>
                                </div>
                        </div>

                        
                        <!-- <a href="contact.html" class="nav-item nav-link">{{ $page.props.translations.Logout  }}</a> -->
                    </div>

                    <div class="d-flex m-3 me-0">
                        <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                        <a href="#" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $page.props.cartCount ?? ''  }}</span>
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
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Page Content -->
    <slot />

    <!-- Footer Start -->
    <div v-if="$page.component != 'Web/Auth/customerLogin'" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">Go Bong Delivery</h1>
                            <p class="text-secondary mb-0">{{ $page.props.translations.Delicious_foods  }}</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" :placeholder="$page.props.translations.Your_Email">
                            <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">{{ $page.props.translations.Subscribe_Now  }}</button>
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
                        <h4 class="text-light mb-3">{{ $page.props.translations.Why_People_Like_us  }}!</h4>
                        <p class="mb-4">{{ $page.props.translations.customer_satisfaction  }}</p>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Go Bong {{ $page.props.translations.Info  }}</h4>
                            <a class="btn-link" href="">{{ $page.props.translations.About_Us  }}</a>
                            <a class="btn-link" href="">{{ $page.props.translations.Contacts  }}</a>
                            <a class="btn-link" href="">{{ $page.props.translations.Info  }}</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">{{ $page.props.translations.Account  }}</h4>
                        <a class="btn-link" href="">{{ $page.props.translations.My_Account  }}</a>
                        <a class="btn-link" href="">{{ $page.props.translations.My_Order  }}</a>
                        <a class="btn-link" href="">{{ $page.props.translations.Terms_Condition  }}</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">{{ $page.props.translations.Contacts  }}</h4>
                        <p>{{ $page.props.translations.Address  }}: Beer City Poipet Zone 3</p>
                        <p>{{ $page.props.translations.Email  }}: gobongdelivery@gmail.com</p>
                        <p>{{ $page.props.translations.Phone_Number  }}: +(855) 69861400</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div v-if="$page.component != 'Web/Auth/customerLogin'" class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>GoBondDelivery.com</a>, {{ $page.props.translations.All_Rights_Reserved  }}.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    {{ $page.props.translations.Designed_By  }} <a class="border-bottom" href="#">ZaffranTech</a> 
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

</div>
</template>
