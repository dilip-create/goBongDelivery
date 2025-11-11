<script setup>
    import { ref, watch } from 'vue'
    import { router, usePage } from '@inertiajs/vue3'

    const props = defineProps({
    stors: Object,
    trendingCategory: Array,
    allCategories: Array,
    groupedFoods: Array,
    filters: Object,
    })

    const appUrl = usePage().props.appUrl

    // 🌟 Reactive filters
    const search = ref(props.filters.search || '')
    const selectedCategory = ref(props.filters.category_id || '')
    const trending = ref(props.filters.trending || '')

    // 🧭 Watch search input (auto-update after typing)
    watch(search, (value) => {
    router.get(
        route('food.list', btoa(props.stors.id)), // make sure route name matches your web.php
        { search: value, category_id: selectedCategory.value, trending: trending.value },
        { preserveState: true, replace: true }
    )
    })

    // 🍔 When clicking a category
    const filterByCategory = (id) => {
    selectedCategory.value = id
    router.get(
        route('food.list', btoa(props.stors.id)),
        { search: search.value, category_id: id, trending: trending.value },
        { preserveState: true, replace: true }
    )
    }

    // ⚡ Trending category button click
    const filterTrending = (id) => {
    selectedCategory.value = id
    router.get(
        route('food.list', btoa(props.stors.id)),
        { search: search.value, category_id: id, trending: 1 },
        { preserveState: true, replace: true }
    )
    }



    // Onclick redirect page code START 
    import axios from "axios";

    const showPopup = ref(false);
    const selectedFood = ref({});
    const suggestion = ref("");
    const quantity = ref(1);
    const cartQuantities = ref({});

    const openFoodDetails = async (food) => {
    selectedFood.value = food;
    showPopup.value = true;

    const { data } = await axios.get(`/cart/${food.id}`);
    if (data.cart) {
        quantity.value = data.cart.f_qty;
        suggestion.value = data.cart.suggetion ?? "";
    } else {
        quantity.value = 1;
        suggestion.value = "";
    }
    };

    const closePopup = () => {
    showPopup.value = false;
    };

    const increaseQty = () => {
    quantity.value++;
    };

    const decreaseQty = () => {
    if (quantity.value > 1) quantity.value--;
    };

    const addToCart = async () => {
    const payload = {
        food_id: selectedFood.value.id,
        quantity: quantity.value,
        suggestion: suggestion.value,
    };

    const { data } = await axios.post("/cart/add", payload);
    if (data.success) {
        cartQuantities.value[selectedFood.value.id] = quantity.value;

        // 🔁 Refresh only cartCount from backend
        router.reload({ only: ["cartCount"] });

        closePopup();
    }
    };
    // Onclick redirect page code END

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

    // 🪟 Modal controls
    const showModal = ref(false)
    const openModal = () => (showModal.value = true)
    const closeModal = () => (showModal.value = false)
</script>
<style scoped>
.page-header {
  min-height: 300px;
}

.btn-close {
  background-color: #f8f9fa;
  border-radius: 50%;
}



.popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  z-index: 999;
  top: 50px;
}
.popup-content {
  max-width: 400px;
  background: white;
  border-radius: 10px;
}
.badge {
  font-size: 0.8rem;
  padding: 4px 6px;
}
</style>

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
            <!-- Rating (Top-Right Corner) -->
            <div class="position-absolute top-0 end-0 m-3 bg bg-primary text-white px-3 py-1 rounded-pill shadow-sm fw-bold" v-if="stors.id">
                <i class="fa fa-star text-secondary"></i> 5.5
            </div>
            <h1 class="text-center text-white display-6">{{ capitalizeFirst(stors.translationforvuepage?.stor_name || stors.cuisine) }}</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">{{ capitalizeFirst(stors.translationforvuepage?.desc || stors.cuisine) }}</a></li>
                
            </ol>
            <button class="btn btn-light position-absolute bottom-0 end-0 m-3 px-4 py-2 shadow rounded-pill" @click="openModal">{{ $page.props.translations['See more stor information'] }}</button>
                <!-- Stor Popup Modal START-->
                <div v-if="showModal" class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center closed-overlay bg-opacity-75" style="z-index: 1050;">
                    <div class="bg-white rounded-4 shadow-lg p-4 position-relative" style="max-width: 600px; width: 90%;">
                        <!-- Close Button -->
                        <button class="btn-close position-absolute top-0 end-0 m-3" @click="closeModal"></button>
                        <!-- Store Image -->
                        <img :src="`/storage/${stors.stor_photo}`" alt="Store Image" class="w-100 rounded-3 mb-3"/>
                        <!-- Store Info -->
                        <h4 class="fw-bold">{{ stors.translationforvuepage?.stor_name || stors.cuisine }} : <i class="fa fa-star text-secondary"></i> 5.5</h4>
                        <p class="text-muted">{{ stors.translationforvuepage?.desc || '' }}</p>
                        <p><strong>{{ stors.cuisine ? $page.props.translations[stors.cuisine] : '' }} : {{ stors.distance_from_office ? stors.distance_from_office+' '+$page.props.translations.km : '' }}</strong></p>
                        <p>{{ $page.props.translations['Opening hours'] }}: {{ stors.opentime ? formatTime(stors.opentime) : '' }} - {{ stors.closetime ? formatTime(stors.closetime) : '' }}</p>
                    </div>
                </div>
                <!-- Stor Popup Modal START-->
        </div>
        <!-- Single Page Header End -->
    <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" v-model="search" class="form-control p-3" :placeholder="$page.props.translations['Search in menu']" aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" :class="{ active: !selectedCategory && !trending }" @click="filterByCategory('')" >
                                    <span class="text-dark" style="width: 130px;">{{ $page.props.translations['All'] }}</span>
                                    </a>
                                </li>

                                <li v-for="catrow in props.trendingCategory" :key="catrow.id" class="nav-item">
                                    <a class="d-flex py-2 m-2 bg-light rounded-pill" @click="filterTrending(catrow.id)" :class="{ active: selectedCategory == catrow.id}">
                                    <span class="text-dark" style="width: 130px;">
                                        {{ capitalizeFirst(catrow.translationforvuepage?.cat_translation_name || catrow.cat_name) }}
                                    </span>
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
                                                <h4>{{ $page.props.translations['Categories'] }}</h4>
                                                <ul class="list-unstyled fruite-categorie">
                                                    
                                                    <li v-for="row in props.allCategories" :key="row.id">
                                                        <div class="d-flex justify-content-between fruite-name">
                                                        <a href="#" @click.prevent="filterByCategory(row.id)" :class="{ activecatColor: selectedCategory == row.id}">
                                                            <i class="fas fa-apple-alt me-2"></i>
                                                            {{ capitalizeFirst(row.translationforvuepage?.cat_translation_name || row.cat_name) }}
                                                        </a>
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

                                                        <div v-for="group in props.groupedFoods" :key="group.category.id" class="mb-5">

                                                            <!-- 🏷 Category Title -->
                                                            <h4 class="mb-4">
                                                            <i v-if="group.is_trending" class="fa fa-fire text-warning me-2"></i>
                                                            {{ capitalizeFirst(group.category.translationforvuepage?.cat_translation_name || group.category.cat_name) }}
                                                            </h4>

                                                            <!-- 🍔 Food Cards -->
                                                            <div class="row g-4">
                                                                <div v-for="records in group.foods" :key="records.id" class="col-lg-6 col-xl-4">
                                                                    <div class="p-4 rounded bg-light">
                                                                        
                                                                    <div class="row align-items-center" @click="openFoodDetails(records)">
                                                                        <div class="col-6">
                                                                        <img
                                                                            v-if="records.food_img"
                                                                            :src="`/storage/${records.food_img}`"
                                                                            class="img-fluid rounded-circle w-100 food-img"
                                                                            alt=""
                                                                        />
                                                                        </div>
                                                                        <div class="col-6">
                                                                        <a href="#" class="h6">
                                                                            {{ capitalizeFirst(records.translationforvuepage?.food_translation_name || records.food_name) }} <span v-if="cartQuantities[records.id]"
                                                                                class="badge bg-danger position-absolute"> <span class="h5 text-white">×</span>{{ cartQuantities[records.id] ?? '' }}
                                                                            </span>
                                                                        </a>
                                                                        
                                                                        <p>{{ capitalizeFirst(records.translationforvuepage?.food_desc ?? '') }}</p>
                                                                        <h6 class="mb-3">
                                                                            {{ records.get_currencies?.currency_symbol ?? '฿' }}{{ records.selling_price ?? '' }}
                                                                        </h6>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        </div>

                                                        <!-- Popup -->
                                                        <div v-if="showPopup" class="popup-overlay d-flex align-items-center justify-content-center">
                                                        <div class="popup-content bg-white rounded p-4 position-relative" style="width: 350px;">
                                                            <button @click="closePopup" class="btn-close position-absolute top-0 end-0 m-2"></button>

                                                            <img :src="`/storage/${selectedFood.food_img}`" class="img-fluid rounded mb-3 food-img" style="height:300px"/>
                                                            <h5>{{ selectedFood.translationforvuepage?.food_translation_name || selectedFood.food_name }}</h5>
                                                            <h6>฿{{ selectedFood.selling_price }}</h6>

                                                            <label class="form-label mt-3">{{ $page.props.translations['Product recommendations (optional)'] }}</label>
                                                            <input v-model="suggestion" type="text" class="form-control" :placeholder="$page.props.translations['Enter here']" />

                                                            <div class="d-flex align-items-center justify-content-center my-3">
                                                            <button @click="decreaseQty" class="btn btn-primary btn-sm">-</button>
                                                            <span class="mx-3">{{ quantity }}</span>
                                                            <button @click="increaseQty" class="btn btn-primary btn-sm">+</button>
                                                            </div>

                                                            <button @click="addToCart" class="btn btn-primary w-100">{{ $page.props.translations['Increase'] }}</button>
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



