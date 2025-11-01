<script setup>
    //For base URL code START
    import { usePage } from '@inertiajs/vue3'
    const appUrl = usePage().props.appUrl;
     //For base URL code ENND
    // Props passed from Laravel controller
    const props = defineProps({
      stors: Array,
      trendingCategory: Array,
      allCategories: Array,
      foods: Array,
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
        
    <!-- Single Page Header start -->
       
        <div class="container-fluid page-header py-5"
            :style="{
                position: 'relative',
                background: `linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('/storage/${stors.stor_photo}')`,
                backgroundPosition: 'center center',
                backgroundSize: 'cover',
                backgroundRepeat: 'no-repeat',
            }">
            <h1 class="text-center text-white display-6">{{ stors.translationforvuepage?.stor_name || stors.cuisine }}</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">{{ stors.translationforvuepage?.desc || stors.cuisine }}</a></li>
                
            </ol>
        </div>
        <!-- Single Page Header End -->
    <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                        <span class="text-dark" style="width: 130px;">All</span>
                                    </a>
                                </li>
                                <li v-for="catrow in props.trendingCategory" :key="catrow.id" class="nav-item">
                                    <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                        <span class="text-dark" style="width: 130px;">{{ capitalizeFirst(catrow.translationforvuepage?.cat_translation_name || catrow.cat_name) }}</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <div class="col-lg-3" v-if="props.allCategories.length">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <h4>Categories</h4>
                                                <ul class="list-unstyled fruite-categorie">
                                                    
                                                    <li v-for="row in props.allCategories" :key="row.id">
                                                        <div class="d-flex justify-content-between fruite-name">
                                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>{{ capitalizeFirst(row.translationforvuepage?.cat_translation_name || row.cat_name) }}</a>
                                                            <span>(3)</span>
                                                        </div>
                                                    </li>
                                                   
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane fade show p-0 active">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="row g-4">

                                                        <!-- <div class="col-lg-6 col-xl-4">
                                                            <div class="p-4 rounded bg-light">
                                                                <div class="row align-items-center">
                                                                    <div class="col-6">
                                                                        <img :src="`${appUrl}/website/assets/img/best-product-1.jpg`" class="img-fluid rounded-circle w-100" alt="">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <a href="#" class="h5">Organic Tomato</a>
                                                                        <div class="d-flex my-3">
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star"></i>
                                                                        </div>
                                                                        <h4 class="mb-3">3.12 $</h4>
                                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        
                                                        <div v-for="records in props.foods" :key="records.id" class="col-lg-6 col-xl-4">
                                                            <div class="p-4 rounded bg-light">
                                                                <div class="row align-items-center">
                                                                    <div class="col-6">
                                                                        <img v-if="records.food_img" :src="`/storage/${records.food_img}`" class="img-fluid rounded-circle w-100 food-img" alt="">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <a href="#" class="h6">{{ capitalizeFirst(records.translationforvuepage?.food_translation_name || records.food_name) }}</a>
                                                                        <p>{{ capitalizeFirst(records.translationforvuepage?.food_desc ?? '') }}</p>
                                                                        <!-- <div class="d-flex my-3">
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star"></i>
                                                                        </div> -->
                                                                        <h6 class="mb-3">{{ records.get_currencies?.currency_symbol ?? '฿' }}{{ records.selling_price ?? '' }} </h6>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       

                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane fade show p-0">
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="row g-4">
                                                        <div class="col-lg-6 col-xl-4">
                                                            <div class="p-4 rounded bg-light">
                                                                <div class="row align-items-center">
                                                                    <div class="col-6">
                                                                        <img :src="`${appUrl}/website/assets/img/best-product-1.jpg`" class="img-fluid rounded-circle w-100" alt="">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <a href="#" class="h5">Organic Tomato</a>
                                                                        <div class="d-flex my-3">
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star"></i>
                                                                        </div>
                                                                        <h4 class="mb-3">3.12 $</h4>
                                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-xl-4">
                                                            <div class="p-4 rounded bg-light">
                                                                <div class="row align-items-center">
                                                                    <div class="col-6">
                                                                        <img :src="`${appUrl}/website/assets/img/best-product-1.jpg`" class="img-fluid rounded-circle w-100" alt="">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <a href="#" class="h5">Organic Tomato</a>
                                                                        <div class="d-flex my-3">
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star text-primary"></i>
                                                                            <i class="fas fa-star"></i>
                                                                        </div>
                                                                        <h4 class="mb-3">3.12 $</h4>
                                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->
       
      
</template>



