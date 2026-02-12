<script setup>
    import { ref, onMounted, onUnmounted } from 'vue'
    import axios from "axios";
    import { router, usePage, useForm  } from '@inertiajs/vue3'
    const appUrl = usePage().props.appUrl;
    const page = usePage()
    const t = (key, fallback = key) => {
        return page.props.translations?.[key] ?? fallback
    }

    const props = defineProps({
    OrderRecords: Array,
    shipAddress: Array,
    storData: Array,
    foodLists: Array,
    currencyData: Array,
    })


    //Delivery Tracking functionality code START

        const statusText = ref('')
        const statusImage = ref('')
        const polling = ref(null)

        const deliverySeconds = ref(0)
        const deliveryTimer = ref(null)
        const timerInitialized = ref(false)
        const stopAfterThisPoll = ref(false)

        const STATUS_MAP = {
            pending: {
                    text: t('Waiting for customer confirmation of the order'),
                    image: 'logo/payment-processing.jpg'
                },
                assigntoRider: {
                    text: t('The rider is assigned to deliver goods'),
                    image: 'img/banners/understand.png'
                },
                acceptedbyRider: {   
                    text: t('The rider is accepted the order'),
                    image: 'img/banners/ok.png'
                },
                riderGoingToStor: {
                    text: t('The rider is on his way to the store'),
                    image: 'img/banners/lets-go.png'
                },
                arrivedatstor: {
                    text: t('The rider has arrived at the store'),
                    image: 'img/banners/arrived-store.png'
                },
                onthewayToDeliver: {
                    text: t('The rider is on his way to deliver goods'),
                    image: 'img/banners/step5.png'         //I got the item...I am on the way
                },
                arrivedatLocation: {
                    text: t('The rider has arrived at location'),
                    image: 'img/banners/arrivedatLocation.png'         //Rider have arrived 
                },
                delivered: {
                    text: t('The customer has received the product'),
                    image: 'img/banners/delivered.jpg'         //
                },
                cancelled: {
                    text: t('Order has been cancelled'),
                    image: 'img/banners/cancelled.png'
                }
        }

        const fetchOrderStatus = async () => {
            try {
                const res = await axios.get(
                    `/myOrder/status/${base64Encode(props.OrderRecords.order_key)}`
                )

                const data = res.data
                router.reload(props.OrderRecords);
                    // ❌ STOP conditions
                    if (data.is_today === false ) {
                        stopPolling()
                        stopDeliveryCountdown()
                        return
                    }
                    /* ================STOP POLLING IF FLAG IS SET================ */
                    if (stopAfterThisPoll.value == true) {
                        stopPolling()
                        return
                    }
                /* ===============FINAL STATES → STOP EVERYTHING================== */
                if (data.assign_status == 'delivered' || data.order_status == 'cancelled') {

                    stopDeliveryCountdown()
                    deliverySeconds.value = 0       // 👈 clear UI
                    stopAfterThisPoll.value = true  // 👈 stop polling AFTER this call

                    const statusConfig = STATUS_MAP[data.assign_status]
                    statusText.value = statusConfig.text
                    statusImage.value = `${page.props.appUrl}/website/assets/${statusConfig.image}`

                    return // ❌ VERY IMPORTANT — EXIT HERE
                }

            
                /* ===============INITIALIZE COUNTDOWN ONLY ONCE=================== */
                if (!timerInitialized.value && Number.isFinite(data.remaining_seconds)) {
                    deliverySeconds.value = Math.floor(data.remaining_seconds)
                    timerInitialized.value = true
                    startDeliveryCountdown()
                }

                const statusConfig = STATUS_MAP[data.assign_status] || STATUS_MAP.pending
                statusText.value = statusConfig.text
                statusImage.value = `${page.props.appUrl}/website/assets/${statusConfig.image}`

            } catch (e) {
                console.error(e)
            }
        }

        const startPolling = () => {
            fetchOrderStatus()
            polling.value = setInterval(fetchOrderStatus, 10000)
        }

        const stopPolling = () => {
            if (polling.value) {
                clearInterval(polling.value)
                polling.value = null
            }
        }

        // ⏱ Countdown (REAL TIME)
        const startDeliveryCountdown = () => {
            if (deliveryTimer.value) return

            deliveryTimer.value = setInterval(() => {
                if (deliverySeconds.value > 0) {
                    deliverySeconds.value--
                } else {
                    stopDeliveryCountdown()
                }
            }, 1000)
        }

        const stopDeliveryCountdown = () => {
            if (deliveryTimer.value) {
                clearInterval(deliveryTimer.value)
                deliveryTimer.value = null
            }
        }

        // ⏰ MM:SS formatter
        const formatTime = (seconds) => {
            seconds = parseInt(seconds, 10)

            if (isNaN(seconds) || seconds <= 0) {
                return '00:00'
            }

            const m = Math.floor(seconds / 60)
            const s = seconds % 60

            return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`
        }

        onMounted(startPolling)
        onUnmounted(() => {
            stopPolling()
            stopDeliveryCountdown()
        })
    //Delivery Tracking functionality code END



    // 3-step popup flow AFTER order is delivered START

    // FOR TIP POPUP CODE START
    const showTipsPopup = ref(false)
    const showReviewPopup = ref(false)
    const showReviewPopupstatus = ref(false)
    const showNextOrderPopup = ref(false)

    const deliveryCompletedAt = ref(null)
    const tipsTimeout = ref(null)

    const reviewExists = ref(false) // set this during DB check
    const tipExists = ref(false) // set this during DB check

    import { watch } from 'vue'

    watch(
        () => props.OrderRecords.assign_status,
        (newStatus) => {
            if (newStatus !== 'delivered') return

            // ✅ check order is today
            const today = new Date()
            const orderDate = new Date(props.OrderRecords.order_date)

            const isToday =
                today.getFullYear() === orderDate.getFullYear() &&
                today.getMonth() === orderDate.getMonth() &&
                today.getDate() === orderDate.getDate()

            if (!isToday) return

            // ✅ prevent duplicate timers
            if (deliveryCompletedAt.value) return

            deliveryCompletedAt.value = Date.now()

            // ⏱ DELAY FIRST
            tipsTimeout.value = setTimeout(async () => {
                try {
                    // 🔍 CASE 1: check tips
                    const tipRes = await axios.get(
                        `/check-tip/${props.OrderRecords.order_key}`
                    )

                    // 🔍 CASE 2: check review
                    const reviewRes = await axios.get(
                        `/check-review/${props.OrderRecords.order_key}`
                    )

                    reviewExists.value = reviewRes.data.exists
                    tipExists.value = tipRes.data.exists

                    // 🎯 DECISION TREE
                    if (!tipExists.value) {
                        showTipsPopup.value = true
                        return
                    }

                    if (tipExists.value && !reviewExists.value) {
                        showReviewPopup.value = true
                        return
                    }

                    if (tipExists.value && reviewExists.value) {
                        showNextOrderPopup.value = true
                    }

                } catch (error) {
                    console.error('Popup flow error:', error)
                }
            }, 10000) // ⏱ 10 sec delay
        },
        { immediate: true }
    )


    const tipAmount = ref('5')
    const tipDesc = ref('') 

    const closeTipsPopup = () => {
        showTipsPopup.value = false

        if(!reviewExists.value) {
            showReviewPopup.value = true
        }else{
            showNextOrderPopup.value = true
        }

    }

    const submitTips = () => {
         const desc = tipDesc.value && tipDesc.value.trim() !== '' ? tipDesc.value : 'Nice Delivery'

        router.visit(
            `/tips/${base64Encode(tipAmount.value)}/${base64Encode(desc)}/${base64Encode(props.OrderRecords.order_key)}`
        )
       
    }
    // FOR TIP POPUP CODE END

    // FOR REVIEW LOGIC START
    const reviewRating = ref(0)
    const reviewDesc = ref('')

    const closeReviewPopup = () => {
        showReviewPopup.value = false
        showNextOrderPopup.value = true
    }

    

    const submitReview = async () => {
        await axios.post('/save/reviews', {
            order_key: props.OrderRecords.order_key,
            stor_id: props.OrderRecords.stor_id,
            cust_id: props.OrderRecords.cust_id,
            rating: reviewRating.value,
            desc: reviewDesc.value
        })

        showReviewPopup.value = false
        showReviewPopupstatus.value = true
        showNextOrderPopup.value = true
    }
    // FOR REVIEW LOGIC END

    const closeNextOrderPopup = () => {
        showTipsPopup.value = false
        showReviewPopup.value = false
        showNextOrderPopup.value = false
    }


    // 3-step popup flow AFTER order is delivered END

   

   
    // Onclick show popup food code START 
    
    const showPopup = ref(false);
    const selectedFood = ref({});
    const suggestion = ref("");
    const quantity = ref(1);

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
    // Onclick show popup food code END
    
    // Onclick Cancel order Item code START
    const showCancelPopup = ref(false)
    const cancelReason = ref('')

    const openCancelPopup = () => {
        showCancelPopup.value = true
    }

    const closeCancelPopup = () => {
        showCancelPopup.value = false
        cancelReason.value = ''
    }

    const submitCancel = () => {
        if (!cancelReason.value) {
            alert(t('Please enter cancel reason'))
            return
        }

        router.post('/order/cancel', {
            order_key: props.OrderRecords.order_key,
            cancel_reason: cancelReason.value,
        }, {
            onSuccess: () => {
                closeCancelPopup()
                alert(t('Your order has been cancelled'))
            }
        })
    }
    // Onclick Cancel order Item code END



    const capitalizeFirst = (text) => {
    if (!text) return ''
        return text.charAt(0).toUpperCase() + text.slice(1)
    }
    function base64Encode(value) {
        return window.btoa(String(value));
    }
    const allstor = btoa('All'.toString());
</script>

<template>
    <Head :title="`- ${$page.props.translations['My orders']}`" />
         
        <!-- Fruits Shop Start--><br/><br/><br/><br/>
        <div class="container-fluid fruite py-5">
            <div class="container bg-light p-2 rounded py-1">

                    <div class="order-header d-flex align-items-center">
                        <Link :href="route('orderlist')">
                            <button class="btn back-btn me-3">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                        </Link>

                        <div class="text-center flex-grow-1">
                            <h5 class="mb-0 text-white fw-semibold">
                                <strong>{{ $page.props.translations['My orders'] }}</strong>
                            </h5>
                            <h5 v-if="deliverySeconds > 0 && OrderRecords.order_status !== 'cancelled' && OrderRecords.order_status !== 'delivered'" class="mb-0 text-white fw-semibold">
                                {{ $page.props.translations['Estimated delivery time'] }}:
                                <strong>{{ formatTime(deliverySeconds) }}</strong>
                            </h5>


                        </div>
                    </div>

                    <div v-if="statusText" class="alert alert-success mb-4 text-center">
                        <strong>{{ statusText }}.</strong>
                    </div>

                    <div v-if="statusImage" class="text-center">
                        <img
                            :src="statusImage"
                            class="img-fluid mb-3 rounded"
                            style="max-width:300px;"
                        />
                    </div>

                
            </div>
        </div>
        <!-- Fruits Shop End-->

        <!-- Cart Page Start -->
        <div class="container-fluid">
            <div class="container bg-light p-2 rounded">
                <div class="row align-items-center">
                    <!-- Left: Heading -->
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6"><br/>
                        <h6 class="mb-0">{{ $page.props.translations['Order Details'] }}</h6>
                         <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <b>{{ $page.props.translations['Orders from'] }}:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6>{{ capitalizeFirst(storData.translationforvuepage?.stor_name || storData.cuisine) }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <b>{{ $page.props.translations['Order ID'] }}:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6># {{ capitalizeFirst(OrderRecords.order_key ?? '') }}</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <b>{{ $page.props.translations['Order Status'] }}:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6><span :class="['text', OrderRecords.order_status == 'cancelled' ? 'text-danger' : 'text-primary']">{{ capitalizeFirst(OrderRecords.order_status ?? '') }}</span></h6>
                                                <p v-if="OrderRecords.order_status == 'cancelled'" class="mb-2">{{ capitalizeFirst(OrderRecords?.cancel_reason) ?? '' }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <b>{{ $page.props.translations['Payment Status'] }}:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6><span :class="['text', OrderRecords.payment_status == 'success' ? 'text-primary' : '']">{{ capitalizeFirst(OrderRecords.payment_status) }}</span></h6>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <b>{{ $page.props.translations['Distance'] }}:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6>{{ OrderRecords.distance_between_shop_customer ?? '' }} km</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <b>{{ $page.props.translations['Delivery address'] }}:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6><p class="mb-2">{{ capitalizeFirst(shipAddress.address) ?? '' }}, {{ capitalizeFirst(shipAddress.landmark) ?? '' }} Poipet Banteay Meanchey Province</p></h6>
                                            </td>
                                        </tr>
                                        <tr v-if="OrderRecords.special_instructions">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <b>{{ $page.props.translations['Special Instructions'] }}:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6><p class="mb-2">{{ capitalizeFirst(OrderRecords.special_instructions) ?? '' }}</p></h6>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <!-- Right: Button -->
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <h6 class="mb-0">{{ $page.props.translations['List'] }}</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="records in props.foodLists" :key="records.id">

                                            <td scope="row">
                                                <div class="d-flex align-items-center" @click="openFoodDetails(records.stor_food_records)">
                                                    <img  v-if="records.stor_food_records?.food_img" :src="`/storage/${records.stor_food_records.food_img}`" 
                                                    class="img-fluid rounded-circle" style="width: 80px; height: 80px;" alt=""> 
                                                    &nbsp;<i class="fa fa-times"></i><b>{{ records.f_qty }}</b>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 mt-4">{{ capitalizeFirst(records.stor_food_records.translationforvuepage?.food_translation_name ?? '') }}</p>
                                            </td>
                                            <td><br/>
                                                <h6>{{ records.stor_food_records.get_currencies?.currency_symbol ?? '' }} {{ records.f_qty * records.stor_food_records.selling_price ?? '' }}</h6>
                                            </td>
                        
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                
                
                <div class="row g-4 justify-content-end">
                    <div class="col-6"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-6">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h6 class="display-6 mb-4"> <span class="fw-normal">{{ $page.props.translations['Price summary'] }}</span></h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 me-4">{{ $page.props.translations['Total'] }}:</h6>
                                    <p class="mb-0">{{ currencyData.currency_symbol ?? '' }} {{ OrderRecords.subTotal ?? '' }}</p>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0 me-4">{{ $page.props.translations['Delivery cost'] }}</h6>
                                        <p class="mb-0">{{ currencyData.currency_symbol ?? '' }} {{ OrderRecords.shipping_charge ?? '' }}</p>
                                </div>
                                <div v-if="OrderRecords.minimum_order_diffrence > 0" class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0 me-4 text-danger">{{ $page.props.translations['Minimum order difference'] }}</h6>
                                        <p class="mb-0 text-danger">{{ currencyData.currency_symbol ?? '฿' }} {{ OrderRecords.minimum_order_diffrence ?? '' }}</p>
                                </div>
                                <div v-if="OrderRecords.new_customer_discount > 0" class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 text-primary">{{ $page.props.translations['New customer discount'] }}:</h6>
                                    <p class="mb-0 text-primary">{{ currencyData.currency_symbol ?? '฿' }} -{{ OrderRecords.new_customer_discount ?? '' }}</p>
                                </div>
                                <div v-if="OrderRecords.discount_offer > 0" class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 text-primary">{{ $page.props.translations['Discount'] }}:</h6>
                                    <p class="mb-0 text-primary">{{ currencyData.currency_symbol ?? '' }} -{{ OrderRecords.discount_offer ?? '' }}</p>
                                </div>
                            </div>
                            <div class="py-3 mb-2 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4">{{ $page.props.translations['Total'] }}</h5>
                                <h6>{{ currencyData.currency_symbol ?? '' }} {{ OrderRecords.totalPayAmount ?? '' }}</h6>
                            </div>

                            <div class="row align-items-stretch">
                                <div class="col-8">
                                    <button class="btn btn-primary px-2 py-2 text-white mb-4 ms-4 w-100">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="btn-text">
                                                {{ $page.props.translations['Total net (including tax)'] }}
                                            </span>
                                            <span class="fw-bold">
                                                {{ currencyData.currency_symbol ?? '' }}
                                                {{ OrderRecords.totalPayAmount ?? '' }}
                                            </span>
                                        </div>
                                    </button>

                                </div>
                                <div class="col-4 d-flex">                           
                                            <button v-if="OrderRecords.order_status !== 'cancelled' && OrderRecords.order_status !== 'delivered' &&
                                                    OrderRecords.assign_status !== 'onthewayToDeliver' && OrderRecords.assign_status !== 'arrivedatLocation'"
                                                class="btn btn-danger px-2 py-2 text-white mb-4 ms-4 w-100" @click="openCancelPopup">
                                                {{ $page.props.translations['Cancel'] }}
                                            </button>

                                            <!-- Cancel Popup -->
                                            <div v-if="showCancelPopup" class="popup-overlay d-flex align-items-center justify-content-center">
                                                <div class="popup-content bg-white rounded p-4 position-relative" style="width: 400px;">
                                                    <button class="btn-close position-absolute top-0 end-0 m-2" @click="closeCancelPopup"></button>

                                                    <h5 class="mb-3">{{ $page.props.translations['Cancel Order'] }}</h5>

                                                    <textarea v-model="cancelReason" class="form-control mb-3" rows="4" :placeholder="$page.props.translations['Enter Cancellation reason']"></textarea>

                                                    <button class="btn btn-danger w-100" @click="submitCancel">{{ $page.props.translations['Submit'] }}</button>
                                                </div>
                                            </div>

                                </div>
                            </div>

                           
                           
                            
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
        <!-- Cart Page End -->
     
   <!-- Edit Popup START-->
    <div v-if="showPopup" class="popup-overlay d-flex align-items-center justify-content-center">
        <div class="popup-content bg-white rounded p-4 position-relative" style="width: 350px;">
            <button @click="closePopup" class="btn-close position-absolute top-0 end-0 m-2"></button>

            <div class="d-flex justify-content-center">
                <img :src="`/storage/${selectedFood.food_img}`" class="img-fluid rounded mb-3 cart-popup-img"/>
            </div>
            <h5>{{ selectedFood.translationforvuepage?.food_translation_name || selectedFood.food_name }}</h5>
            <p>{{ selectedFood.translationforvuepage?.food_desc || selectedFood.food_desc }}</p>
            <h6>{{ selectedFood.get_currencies?.currency_symbol ?? '฿' }}{{ selectedFood.selling_price }}</h6>
            <span v-if="selectedFood.cooking_time>0">{{ $page.props.translations['Making in'] }} : {{ selectedFood.cooking_time }}min</span>
            <!-- <label class="form-label mt-3">{{ $page.props.translations['Product recommendations (optional)'] }}</label>
            <input v-model="suggestion" type="text" class="form-control" :placeholder="$page.props.translations['Enter here']" /> -->

            <!-- <div class="d-flex align-items-center justify-content-center my-3">
            <button @click="decreaseQty" class="btn btn-primary btn-sm">-</button>
            <span class="mx-3">{{ quantity }}</span>
            <button @click="increaseQty" class="btn btn-primary btn-sm">+</button>
            </div> -->

            <!-- <button @click="addToCart" class="btn btn-primary w-100">{{ $page.props.translations['Increase'] }}</button> -->
        </div>
    </div>
    <!-- Edit Popup END-->

    <!-- TIPS POPUP START-->
    <div v-if="showTipsPopup" class="modal-overlay popup-overlay d-flex align-items-center justify-content-center">
        <div class="modal-box popup-content bg-white rounded p-4 position-relative" style="width: 500px;">
            <!-- <button @click="closeTipsPopup" class="btn-close position-absolute top-0 end-0 m-2"></button> -->
            <img :src="`${appUrl}/website/assets/img/banners/tips.png`" class="img-fluid rounded mb-3 cart-popup-img" />
            <h6 class="mb-3">{{ $page.props.translations['Would you like to tip the rider'] }}?</h6>
            <div class="d-flex gap-3 justify-content-center">
                <label><input type="radio" checked class="form-check-input bg-primary border-0" v-model="tipAmount" value="5"> ฿5</label>
                <label><input type="radio" class="form-check-input bg-primary border-0" v-model="tipAmount" value="10"> ฿10</label>
                <label><input type="radio" class="form-check-input bg-primary border-0" v-model="tipAmount" value="15"> ฿15</label>
            </div>
            <textarea v-model="tipDesc" class="form-control mt-3" :placeholder="$page.props.translations['Write something nice...']"></textarea>
            <div class="mt-3 d-flex justify-content-between">
                <button class="btn btn-gray" @click="closeTipsPopup">{{ $page.props.translations['Skip'] }}</button>
                <button class="btn btn-primary" @click="submitTips">{{ $page.props.translations['Tip Now'] }} ฿{{ tipAmount ?? '' }}</button>
            </div>
        </div>
    </div>
    <!-- TIPS POPUP END-->

    <!-- REVIEW POPUP  START-->
        <div v-if="showReviewPopup" class="modal-overlay popup-overlay d-flex align-items-center justify-content-center">
            <div class="modal-box popup-content bg-white rounded p-4 position-relative" style="width: 500px;">
                <img :src="`${appUrl}/website/assets/img/banners/leave-comment.png`" class="img-fluid rounded mb-3 cart-popup-img" />
                <h6>{{ $page.props.translations['Please Rate & comment on your delivery'] }}</h6>

                <div class="stars">
                    <i v-for="n in 5" :key="n" class="fa-star" :class="reviewRating >= n ? 'fas text-warning' : 'far'" @click="reviewRating = n"></i>
                </div>

                <textarea v-model="reviewDesc" class="form-control mt-3" placeholder="Leave a comment"></textarea>

                <div class="mt-3 d-flex justify-content-between">
                    <button class="btn btn-gray" @click="closeReviewPopup">{{ $page.props.translations['Skip'] }}</button>
                    <button class="btn btn-primary" @click="submitReview">{{ $page.props.translations['Submit Review'] }}</button>
                </div>
            </div>
        </div>
    <!-- REVIEW POPUP END-->

    <!-- NEXT ORDER POPUP START-->
        <div v-if="showNextOrderPopup" class="modal-overlay popup-overlay d-flex align-items-center justify-content-center">
            <div class="modal-box popup-content bg-white rounded p-4 position-relative" style="width: 500px;">
                <div v-if="showReviewPopupstatus" class="alert alert-success mb-4 text-center">
                        <strong>{{ $page.props.translations['Thanks for Review'] }}.</strong>
                </div>
                <img :src="`${appUrl}/website/assets/img/banners/next-order.png`" class="img-fluid rounded mb-3 cart-popup-img" />

                <h6>{{ $page.props.translations['Do you want to place your next order'] }}?</h6>
                <div class="mt-3 d-flex justify-content-between">
                    <button class="btn btn-gray" @click="closeNextOrderPopup">{{ $page.props.translations['Skip'] }}</button>
                    <Link :href="`/stores/${allstor}`" class="btn btn-primary mt-3">Order Now <i class="fa fa-arrow-right"></i></Link>
                </div>
                
            </div>
        </div>
    <!-- NEXT ORDER POPUP END-->



      
</template>



