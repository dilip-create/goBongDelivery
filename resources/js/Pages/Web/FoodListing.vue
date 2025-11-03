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
            <h1 class="text-center text-white display-6">{{ capitalizeFirst(stors.translationforvuepage?.stor_name || stors.cuisine) }}</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">{{ capitalizeFirst(stors.translationforvuepage?.desc || stors.cuisine) }}</a></li>
                
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
                                    <input type="search" v-model="search" class="form-control p-3" :placeholder="$page.props.translations['Search in menu']" aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" :class="{ active: !selectedCategory && !trending }"
                                    @click="filterByCategory('')" >
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
                                                                <div class="row align-items-center">
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
                                                                        {{ capitalizeFirst(records.translationforvuepage?.food_translation_name || records.food_name) }}
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



