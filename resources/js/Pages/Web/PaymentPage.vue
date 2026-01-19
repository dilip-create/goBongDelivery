<script setup>
    import TextInput from '../Components/TextInput.vue'
    import Textarea from '../Components/Textarea.vue'
    import { ref } from 'vue'
    import { router, usePage, useForm  } from '@inertiajs/vue3'
    const page = usePage()
    const t = (key, fallback = key) => {
        return page.props.translations?.[key] ?? fallback
    }

    const props = defineProps({
    OrderData: Array,
    shipAddress: Array,
    storData: Array,
    foodLists: Array,
    currencyData: Array,
    
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


    const form = useForm({
        // total_cost_price: props.OrderData.total_cost_price ?? 0,
        // sub_total: props.OrderData.sub_total ?? 0,
        // distance: props.OrderData.distance ?? 0,
        // shippingCharge: props.OrderData.shippingCharge ?? 0,
        // minimum_order_diffrence: props.OrderData.minimum_order_diffrence ?? 0,
        // new_customer_discount: props.OrderData.new_customer_discount ?? 0,
        // discount_offer: props.OrderData.discount_offer ?? 0,
        // final_amount: props.OrderData.final_amount ?? 0,
        // discount_offer: props.OrderData.discount_offer ?? 0,
        special_instructions: '',
    })

    /** SUBMIT (CREATE + UPDATE) */
    const submit = () => {
        form.post(route('save.checkout'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
                // isEditMode.value = false
                // activeTab.value = 'all'
            },
        })
    }



const copied = ref(false)

const copyAccountNumber = async () => {
    const text = 'Kbank 2133898681'

    try {
        await navigator.clipboard.writeText(text)
        copied.value = true

        setTimeout(() => {
            copied.value = false
        }, 1500)
    } catch (e) {
        console.error('Copy failed', e)
    }
}



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
                            {{ capitalizeFirst(storData.translationforvuepage?.stor_name || storData.cuisine) }} <br/> {{ $page.props.translations['Make payment'] ?? '' }}
                        </h5>
                    </div>
                </div>

                <div class="row align-items-center py-2">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="d-flex justify-content-center">
                            <img :src="`${$page.props.appUrl}/website/assets/logo/gobong-qr.jpg`" alt="QR" height="450" width="300" class="bg-primary rounded"/>
                        </div>
                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3 cursor-pointer" @click="copyAccountNumber">
                            <span class="fw-bold">Kbank 2133898681</span>
                           <i :class="copied ? 'fa fa-check text-success' : 'fa fa-copy'"></i>
                        </div>
                        <small v-if="copied" class="text-success d-block text-center mt-1">
                            {{ $page.props.translations['Copied'] }}!
                        </small>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
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
                    <div class="col-5 text-end"></div>
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
                                    <div class="d-flex align-items-center" @click="openFoodDetails(records.stor_food_records)">
                                        <img  v-if="records.stor_food_records?.food_img" :src="`/storage/${records.stor_food_records.food_img}`" 
                                        class="img-fluid rounded-circle" style="width: 80px; height: 80px;" alt=""> 
                                        &nbsp;<i class="fa fa-times"></i><b>{{ records.cartdetails?.f_qty }}</b>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ capitalizeFirst(records.stor_food_records.translationforvuepage?.food_translation_name || records.stor_food_records.food_name) }}</p>
                                </td>
                                <td><br/>
                                    <h6>{{ records.stor_food_records.get_currencies?.currency_symbol ?? '' }} {{ records.cartdetails.f_qty * records.stor_food_records.selling_price ?? '' }}</h6>
                                </td>
            
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <form @submit.prevent="submit">
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h6 class="display-6 mb-4"> <span class="fw-normal">{{ $page.props.translations['Price summary'] }}</span></h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 me-4">{{ $page.props.translations['Total'] }}:</h6>
                                    <p class="mb-0">{{ currencyData.currency_symbol ?? '' }} {{ OrderData.subTotal ?? '' }}</p>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0 me-4">{{ $page.props.translations['Shipping cost'] }}</h6>
                                        <p class="mb-0">{{ currencyData.currency_symbol ?? '' }} {{ OrderData.shipping_charge ?? '' }}</p>
                                </div>
                                <div v-if="OrderData.minimum_order_diffrence > 0" class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0 me-4 text-danger">{{ $page.props.translations['Minimun order diffrence'] }}</h6>
                                        <p class="mb-0 text-danger">{{ currencyData.currency_symbol ?? '฿' }} {{ OrderData.minimum_order_diffrence ?? '' }}</p>
                                </div>
                                <div v-if="OrderData.new_customer_discount > 0" class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 text-primary">{{ $page.props.translations['New customer discount'] }}:</h6>
                                    <p class="mb-0 text-primary">{{ currencyData.currency_symbol ?? '฿' }} -{{ OrderData.new_customer_discount ?? '' }}</p>
                                </div>
                                <div v-if="OrderData.discount_offer > 0" class="d-flex justify-content-between mb-2">
                                    <h6 class="mb-0 text-primary">{{ $page.props.translations['Discount'] }}:</h6>
                                    <p class="mb-0 text-primary">{{ currencyData.currency_symbol ?? '' }} -{{ OrderData.discount_offer ?? '' }}</p>
                                </div>
                            </div>
                            <div class="py-3 mb-2 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4">{{ $page.props.translations['Total'] }}</h5>
                                <h6>{{ currencyData.currency_symbol ?? '' }} {{ OrderData.totalPayAmount ?? '' }}</h6>
                            </div>

                            <div class="row justify-content-between">
                                <!-- Left: Heading -->
                                <div class="col-8 text-start">
                                   <button class="btn btn-primary text-white mb-4 ms-4 w-100" :disabled="form.processing">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <p class="btn-text">{{ $page.props.translations['Total net (including tax)'] }}</p>
                                            <p class="fw-bold">
                                                {{ currencyData.currency_symbol ?? '' }}
                                                {{ OrderData.totalPayAmount ?? '' }}
                                            </p>
                                        </div>
                                    </button>

                                </div>
                                <!-- Right: Button -->
                                <div class="col-4 text-start">
                                    <button class="btn btn-danger text-white ms-4" :disabled="form.processing"><p class="btn-text">{{ $page.props.translations['Cancel'] }}</p></button>
                                </div>
                            </div>
                           
                           
                            
                        </div>
                    </div>
                    
                </div>
                
                </form>
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
      
</template>



