<script setup>
    import { ref } from 'vue'
    import { router, usePage  } from '@inertiajs/vue3'
    const page = usePage()
    const t = (key, fallback = key) => {
        return page.props.translations?.[key] ?? fallback
    }

    const props = defineProps({
    shipAddress: Array,
    storData: Array,
    foodLists: Array,
    summary: Array,
   
    })
   

   
    // Onclick Edit popup cart code START 
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
        stor_id: selectedFood.value.stor_id,
        food_id: selectedFood.value.id,
        quantity: quantity.value,
        suggestion: suggestion.value,
    };

    const { data } = await axios.post("/cart/add", payload);
    if (data.success) {
        cartQuantities.value[selectedFood.value.id] = quantity.value;

        // 🔁 Refresh only cartCount from backend
        // router.reload({ only: ["cartCount"] });
        router.reload();
        closePopup();
    }
    };
    // Onclick Edit popup cart code END


    // Onclick Delete Item code START
        import Swal from 'sweetalert2';
        const deleteInCartFun = async (cartId) => {
        
            Swal.fire({
                title: t('Are you sure?'),
                text: t('This item will be deleted'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: t('Yes, delete it')
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/cart/${cartId}`)
                        .then(() => {
                            Swal.fire(
                                t('Deleted!'),
                                t('Item deleted'),
                                'success'
                            )
                            // refresh the page without reload reload whole page
                            router.reload();
                            
                        })
                }
            })
        }
    // Onclick Delete Item code START


    const capitalizeFirst = (text) => {
    if (!text) return ''
        return text.charAt(0).toUpperCase() + text.slice(1)
    }
    function base64Encode(value) {
        return window.btoa(String(value));
    }
</script>

<template>
    <Head :title="`- ${$page.props.translations['Cart']}`" />
         
        <!-- Fruits Shop Start--><br/><br/><br/><br/>
        <div class="container-fluid fruite py-5">
            <div class="container bg-light p-2 rounded py-1">
                <div class="order-header d-flex align-items-center">
                    <!-- Back button -->
                        <Link :href="route('/')"><button class="btn back-btn me-3"><i class="fas fa-arrow-left"></i></button></Link>
                    <div class="text-center flex-grow-1">
                        <h5 class="mb-0 text-white fw-semibold">
                            {{ capitalizeFirst(storData.translationforvuepage?.stor_name || storData.cuisine) }} <br/> {{ $page.props.translations['Order summary'] ?? 'Order summary' }}
                        </h5>
                        <small class="text-white-50">
                            {{ $page.props.translations['Distance'] ?? 'Distance' }} : {{ storData.distance_from_office ? storData.distance_from_office+' '+$page.props.translations.km : '' }}
                        </small>
                    </div>
                </div>

                <div class="row align-items-center py-2">
                    <!-- Left: Heading -->
                    <div class="col-7 text-start">
                        <h6 class="mb-0">{{ $page.props.translations['Choose a shipping address'] }}</h6><br/>
                        <div class="map-box">
                                <iframe class="rounded w-100" 
                                style="height: 200px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-73.97968099999999!3d40.6974881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1694259649153!5m2!1sen!2sbd" 
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <!-- Right: Button -->
                    <div class="col-5 text-end">
                         <Link :href="route('shipping.address.list')"><button class="btn btn-outline-dark px-4">{{ $page.props.translations['CHANGE SHIPPING ADDRESS'] }}</button></Link>
                        <div class="address-box">
                                <!-- <h4>Poipet Banteay Meanchey Province</h4>
                                <h6 >Beer City Poipet Zone 3 </h6>  -->
                                <div class="d-flex p-4 rounded mb-4">
                                    <i class="fas fa-map-marker-alt fa-2x text-danger"></i>&nbsp;
                                    <div>
                                        <h4>Poipet Banteay Meanchey Province</h4>
                                        <p class="mb-2"> {{ capitalizeFirst(shipAddress.address) ?? '' }}, {{ capitalizeFirst(shipAddress.landmark) ?? '' }}</p>
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->

        <!-- Cart Page Start -->
        <div class="container-fluid">
            <div class="container bg-light p-2 rounded">
                <div class="row align-items-center">
                    <!-- Left: Heading -->
                    <div class="col-7 text-start">
                        <h6 class="mb-0">{{ $page.props.translations['List'] }}</h6><br/>
                    </div>
                    <!-- Right: Button -->
                    <div class="col-5 text-end">
                     <Link :href="`/menus/${base64Encode(storData.id)}`"><button class="btn btn-outline-dark">{{ $page.props.translations['ADD A LIST'] }}</button></Link>
                    </div>
                </div>
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
                                    <div class="d-flex align-items-center">
                                        <img v-if="records.food_img" :src="`/storage/${records.food_img}`" class="img-fluid rounded-circle" style="width: 80px; height: 80px;" alt=""> 
                                        &nbsp;<i class="fa fa-times"></i><b>{{ records.f_qty }}</b>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ capitalizeFirst(records.translationforvuepage?.food_translation_name || records.food_name) }}</p>
                                    <button @click="openFoodDetails(records)" class="btn btn-md rounded-circle bg-light border">
                                        <i class="fa fa-edit text-danger"></i>
                                    </button>
                                    <button @click="deleteInCartFun(records.cart_id)" class="btn btn-md rounded-circle bg-light border">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                                <td><br/><br/>
                                    <h6>{{ records.get_currencies?.currency_symbol ?? '฿' }} {{ records.f_qty * records.selling_price ?? '' }}</h6>
                                </td>
            
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
               <div class="row align-items-center">
                    <div class="col-7 text-start">
                        <h6 class="mb-0">{{ $page.props.translations['Is there a discount coupon'] }} ?</h6><br/>
                    </div>
                    <div class="col-5 text-end">
                        <button class="btn btn-primary px-4 text-white">{{ $page.props.translations['USE COUPONS'] }}</button>
                    </div>
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <!-- <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1> -->
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 me-4">{{ $page.props.translations['Total'] }}:</h6>
                                    <p class="mb-0">{{ foodLists.get_currencies?.currency_symbol ?? '฿' }} {{ summary.sub_total ?? '' }}</p>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 me-4">{{ $page.props.translations['Shipping cost'] }}</h6>
                                    <div class="">
                                        <p class="mb-0">{{ foodLists.get_currencies?.currency_symbol ?? '฿' }} {{ summary.shipping_cost ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0">{{ $page.props.translations['New customer discount'] }}:</h6>
                                    <p class="mb-0">{{ foodLists.get_currencies?.currency_symbol ?? '฿' }} {{ summary.new_customer_discount ?? '' }}</p>
                                </div>
                            </div>
                            <div class="py-3 mb-2 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4">{{ $page.props.translations['Total'] }}</h5>
                                <h6>{{ foodLists.get_currencies?.currency_symbol ?? '฿' }} {{ summary.final_amount ?? '' }}</h6>
                            </div>
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">{{ $page.props.translations['Confirm Order'] }}</button>
                        </div>
                    </div>
                    <div class="col-8"></div>
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
            <h6>{{ selectedFood.get_currencies?.currency_symbol ?? '฿' }}{{ selectedFood.selling_price }}</h6>

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
    <!-- Edit Popup END-->
      
</template>



