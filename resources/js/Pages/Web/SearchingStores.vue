<script setup>
    //For base URL code START
    import { router, usePage } from '@inertiajs/vue3'
    const appUrl = usePage().props.appUrl;
     //For base URL code ENND
    // Props passed from Laravel controller
    const props = defineProps({
      stors: Array,
      keyword: Array,
    })

    //Onclick redirect page code START 
    const openMenu = (id) => {
    // Encode ID using base64
    const storId = btoa(id.toString())
    router.get(`/menus/${storId}`)
    }
    //Onclick redirect page code END

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
    <Head :title="`- ${capitalizeFirst(keyword)}`"></Head>
       
       <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5"><br/><br/><br/>
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <!-- <h2>{{ capitalizeFirst(keyword) }}</h2> -->
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div v-if="props.stors.length" class="row g-4">

                                        <div v-for="stor in props.stors" :key="stor.id" class="col-6 col-md-4 col-lg-2">
                                            
                                            <div class="rounded position-relative fruite-item">
                                                
                                                <div class="fruite-img" @click="openMenu(stor.id)">
                                                    <img  v-if="stor.stor_photo" :src="`/storage/${stor.stor_photo}`" class="promotion-img img-fluid w-100 rounded-top" alt="">
                                                     <!-- Closed Shop Overlay -->
                                                        <div v-if="stor.openStatus == 0" class="closed-overlay d-flex align-items-center justify-content-center" >
                                                            <span class="text-white fw-bold fs-5">{{ $page.props.translations.Closed }}</span>
                                                        </div>
                                                </div>
                                               
                                                <div v-if="stor.new_arrival==1" class="promo-badge">
                                                    <img :src="`${appUrl}/website/assets/img/categories/new-arrival.jpg`" alt="New">
                                                </div>

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
                                    <div v-else class="text-gray-500">Not found.</div>
                                </div>
                            </div>
                        </div>
                    
                       
                       
                        
                    </div>
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->
        

      
</template>



