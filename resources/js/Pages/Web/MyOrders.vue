<script setup>
import { router, usePage } from '@inertiajs/vue3'
const appUrl = usePage().props.appUrl;
 const props = defineProps({
    orderLists: Array,
   
    })

  //Onclick redirect page code START 
    const openMenu = (orderkey) => {
       
    // Encode ID using base64
    const order_key = btoa(orderkey.toString())
    
    router.get(`/myOrder/orderDetails/${order_key}`)
    }
    //Onclick redirect page code END

    const capitalizeFirst = (text) => {
    if (!text) return ''
        return text.charAt(0).toUpperCase() + text.slice(1)
    }
</script>
<style>
.order-card {
    border: 1px solid #eee;
}

/* Row layout */
.order-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    font-size: 14px;
}

/* Status badge */
.order-row .badge {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 12px;
}

/* Mobile spacing */
@media (max-width: 767px) {
    .order-row {
        font-size: 13px;
    }
}


</style>



<template>
    <Head :title="`- ${$page.props.translations['Shipping Address']}`" />
         
    <!-- Fruits Shop Start--><br/><br/>
        <div class="container-fluid fruite py-5">
            <div class="container py-5 bg-light">
                <div class="order-header d-flex align-items-center">
                    <!-- Back button -->
                    <Link :href="route('cart')"><button class="btn back-btn me-3"><i class="fas fa-arrow-left"></i></button></Link>
                    <div class="text-center flex-grow-1">
                        <h5 class="mb-0 text-white fw-semibold">{{ $page.props.translations['My order'] }}</h5>
                    </div>
                </div><br/>
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    
                                        <div v-for="records in props.orderLists" :key="records.id" class="order-card p-4 rounded mb-4 bg-white" @click="openMenu(records.order_key)">
                                            <div class="order-row">
                                                <span>{{ $page.props.translations['Order ID'] }}</span>
                                                <span>{{ records.order_key }}</span>
                                            </div>

                                            <div class="order-row">
                                                <span>{{ $page.props.translations['Store name'] }}</span>
                                                <span>{{ records.getstor.translationforvuepage.stor_name }}</span>
                                            </div>

                                            <div class="order-row text-muted small">
                                                <span></span>
                                                <span>{{ records.stor_food_records.translationforvuepage?.food_translation_name }}</span>
                                            </div>

                                            <div class="order-row">
                                                <span>{{ $page.props.translations['Date'] }}</span>
                                                <span>{{ records.order_date }}</span>
                                            </div>

                                            <div class="order-row">
                                                <span>{{ $page.props.translations['Status'] }}</span>
                                                <span
                                                    class="badge"
                                                    :class="{
                                                        'bg-success': records.order_status === 'delivered',
                                                        'bg-warning': records.order_status === 'ordered',
                                                        'bg-danger': records.order_status === 'cancelled',
                                                        'bg-warning text-dark': records.order_status === 'pending'
                                                    }"
                                                >
                                                    {{ capitalizeFirst(records.order_status ?? '') }}
                                                </span>

                                            </div>
                                            <!-- <div v-if="records.order_status === 'success'" class="order-row">
                                                <span>{{ $page.props.translations['Payment Status'] }}</span>
                                                <span
                                                    class="badge"
                                                    :class="{
                                                        'bg-success': records.payment_status === 'success',
                                                        'bg-danger': records.payment_status === 'pending',
                                                        'bg-warning text-dark': records.payment_status === 'awaiting verification'
                                                    }"
                                                >
                                                    {{ capitalizeFirst(records.payment_status ?? '') }}
                                                </span>
                                            </div> -->
                                        </div>



                                </div>
                                
                                
                            </div>
                        </div>
                         <div class="col-lg-2"></div>
                    </div>

                
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->


        
 
      
</template>



