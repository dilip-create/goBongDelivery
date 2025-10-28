<script setup>
    // import your components
    import Carousel from '../Components/HomeCarousel.vue'
    //For base URL code START
    import { usePage } from '@inertiajs/vue3'
    const appUrl = usePage().props.appUrl;
     //For base URL code ENND
    // Props passed from Laravel controller
    const props = defineProps({
      stors: Array,
      recommendedstors: Array,
    })


    // Format "HH:mm:ss" → "hh:mm AM/PM" Code START
    const formatTime = (timeString) => {
    if (!timeString) return ''
    const [hour, minute] = timeString.split(':')
    const date = new Date()
    date.setHours(parseInt(hour), parseInt(minute))

    // toLocaleTimeString gives 12-hour time with AM/PM
    return date.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    })
    }
    // Format "HH:mm:ss" → "hh:mm AM/PM" Code END
    const capitalizeFirst = (text) => {
    if (!text) return ''
        return text.charAt(0).toUpperCase() + text.slice(1)
    }
</script>


<template>
    <Head :title="'- ' + $page.props.translations.Home"></Head>
        <!-- Hero Start -->
        <div class="container-fluid hero-header">
            <div class="container py-2">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">{{ $page.props.translations.Welcome }} Go Bong! </h4>
                        <h3 class="mb-5 text-primary hidden">{{ $page.props.translations.signup_text  }}</h3>
                        <div class="position-relative mx-auto">
                            <input class="form-control border-2 border-secondary w-75 py-2 rounded-pill" type="number" :placeholder="$page.props.translations.Search_here + '...'">
                            <button type="submit" class="btn btn-primary border-2 border-secondary py-2 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">{{ $page.props.translations.Go }} <i class="fa-solid fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step1.jpg`" class="img-fluid w-100 step-img rounded" alt="First slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step2.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step3.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step4.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step5.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step6.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step7.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step8.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img :src="`${appUrl}/website/assets/img/banners/step9.png`" class="img-fluid w-100 step-img  rounded" alt="Second slide">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        <!-- Carousel slider START -->
         <Carousel :recommendedstors="recommendedstors" />
         <!-- Carousel slider END -->
       <!-- Fruits Shop Start-->
        <div class="container-fluid fruite">
            <div class="container">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h2>💯{{ capitalizeFirst($page.props.translations['great restaurants']) }}</h2>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div v-if="props.stors.length" class="row g-4">

                                        <div v-for="stor in props.stors" :key="stor.id" class="col-6 col-md-4 col-lg-2">
                                            
                                            <div class="rounded position-relative fruite-item">
                                                
                                                <div class="fruite-img">
                                                    <img  v-if="stor.stor_photo" :src="`/storage/${stor.stor_photo}`" class="promotion-img img-fluid w-100 rounded-top" alt="">
                                                     <!-- Closed Shop Overlay -->
                                                        <div v-if="stor.openStatus == 0" class="closed-overlay d-flex align-items-center justify-content-center" >
                                                            <span class="text-white fw-bold fs-5">{{ $page.props.translations.Closed }}</span>
                                                        </div>
                                                </div>
                                               
                                                  <div class="text-white bg-secondary  rounded position-absolute promotion-trip" style="">{{ stor.openStatus==1 ? 'Promotion' : $page.props.translations.Closed }}</div>
                                                <div class="p-2 border border-secondary border-top-0 rounded-bottom">
                                                           
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark  mb-0">{{ stor.distance_from_office ? stor.distance_from_office+' '+$page.props.translations.km : '' }}</p>
                                                        <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ stor.distance_from_office < 1 ? $page.props.translations['Free shipping'] : '20 bhat' }}</p>
                                                        <p>{{ stor.cuisine ? $page.props.translations[stor.cuisine] : '' }}</p>
                                                    </div>
                                                        <p>{{ $page.props.translations['Opening hours'] }}:{{ stor.opentime ? formatTime(stor.opentime) : '' }}-
                                                        {{ stor.closetime ? formatTime(stor.closetime) : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-for="stor in props.stors" :key="stor.id" class="col-6 col-md-4 col-lg-2">
                                            
                                            <div class="rounded position-relative fruite-item">
                                                <a href="#ddddd">
                                                <div class="fruite-img">
                                                    <img  v-if="stor.stor_photo" :src="`/storage/${stor.stor_photo}`" class="promotion-img img-fluid w-100 rounded-top" alt="">
                                                     <!-- Closed Shop Overlay -->
                                                        <div v-if="stor.openStatus == 0" class="closed-overlay d-flex align-items-center justify-content-center" >
                                                            <span class="text-white fw-bold fs-5">{{ $page.props.translations.Closed }}</span>
                                                        </div>
                                                </div>
                                                </a>
                                                  <div class="text-white bg-secondary  rounded position-absolute promotion-trip" style="">{{ stor.openStatus==1 ? 'Promotion' : $page.props.translations.Closed }}</div>
                                                <div class="p-2 border border-secondary border-top-0 rounded-bottom">
                                                           
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark  mb-0">{{ stor.distance_from_office ? stor.distance_from_office+' '+$page.props.translations.km : '' }}</p>
                                                        <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ stor.distance_from_office < 1 ? $page.props.translations['Free shipping'] : '20 bhat' }}</p>
                                                        <p>{{ stor.cuisine ? $page.props.translations[stor.cuisine] : '' }}</p>
                                                    </div>
                                                        <p>{{ $page.props.translations['Opening hours'] }}:{{ stor.opentime ? formatTime(stor.opentime) : '' }}-
                                                        {{ stor.closetime ? formatTime(stor.closetime) : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                         <div v-for="stor in props.stors" :key="stor.id" class="col-6 col-md-4 col-lg-2">
                                            
                                            <div class="rounded position-relative fruite-item">
                                                <a href="#ddddd">
                                                <div class="fruite-img">
                                                    <img  v-if="stor.stor_photo" :src="`/storage/${stor.stor_photo}`" class="promotion-img img-fluid w-100 rounded-top" alt="">
                                                     <!-- Closed Shop Overlay -->
                                                        <div v-if="stor.openStatus == 0" class="closed-overlay d-flex align-items-center justify-content-center" >
                                                            <span class="text-white fw-bold fs-5">{{ $page.props.translations.Closed }}</span>
                                                        </div>
                                                </div>
                                                </a>
                                                  <div class="text-white bg-secondary  rounded position-absolute promotion-trip" style="">{{ stor.openStatus==1 ? 'Promotion' : $page.props.translations.Closed }}</div>
                                                <div class="p-2 border border-secondary border-top-0 rounded-bottom">
                                                           
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark  mb-0">{{ stor.distance_from_office ? stor.distance_from_office+' '+$page.props.translations.km : '' }}</p>
                                                        <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ stor.distance_from_office < 1 ? $page.props.translations['Free shipping'] : '20 bhat' }}</p>
                                                        <p>{{ stor.cuisine ? $page.props.translations[stor.cuisine] : '' }}</p>
                                                    </div>
                                                        <p>{{ $page.props.translations['Opening hours'] }}:{{ stor.opentime ? formatTime(stor.opentime) : '' }}-
                                                        {{ stor.closetime ? formatTime(stor.closetime) : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div v-else class="text-gray-500">No stores found.</div>
                                </div>
                            </div>
                        </div>
                    
                       
                       
                        
                    </div>
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->
        

      
</template>



