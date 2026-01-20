<script setup>
    // import TextInput from '../Components/TextInput.vue'
   
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
   

   
    // Onclick show popup food code START 
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
    // Onclick show popup food code END


const preview = ref(null)
const hasImage = ref(false)
const isSubmitted = ref(false)

const form = useForm({
    order_key: props.OrderData.order_key,
    avatar: null,
})

function onFileChange(e) {
    const file = e.target.files[0]
    if (!file) return

    form.avatar = file
    preview.value = URL.createObjectURL(file)
    hasImage.value = true
}

const submit = () => {
        form.post(route('save.paymentslip'), {
            preserveScroll: true,
            onSuccess: () => {
                isSubmitted.value = true;
            },
        })
    }








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


    


    // For copy ACC number functionality code START
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
    // For copy ACC number functionality code END


    const capitalizeFirst = (text) => {
    if (!text) return ''
        return text.charAt(0).toUpperCase() + text.slice(1)
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
                        <h5 v-if="isSubmitted" class="mb-0 text-white fw-semibold">{{ $page.props.translations['Processing'] ?? '' }}...</h5>
                        <h5 v-else class="mb-0 text-white fw-semibold">{{ $page.props.translations['Make payment'] ?? '' }}</h5>
                    </div>
                </div>

                <!-- UPLOAD + CONFIRM SECTION -->
                <!-- SUCCESS ALERT -->
                                <div v-if="isSubmitted" class="alert alert-success mb-4 text-center">
                                    <strong>Confirmation successful!</strong>
                                    <br />
                                    The system is now processing your request.
                                </div>

                                <!-- PROCESSING VIEW -->
                                <div v-if="isSubmitted" class="text-center">
                                    <img :src="`${$page.props.appUrl}/website/assets/logo/payment-processing.jpg`" class="img-fluid mb-3" style="max-width:300px;">
                                </div>
                <div v-else class="row align-items-center py-2">
       
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
                
                                    <!-- IMAGE PREVIEW -->
                                    <div v-if="hasImage" class="mb-3 text-center">
                                        <img :src="preview" class="img-fluid rounded shadow" style="max-height:350px;">
                                    </div>

                                    <form @submit.prevent="submit">
                                        <!-- UPLOAD BUTTON -->
                                        <div class="mb-4">
                                            <label class="w-100">
                                                <div class="btn btn-primary w-100 py-3">
                                                    Attach the item confirmation slip
                                                </div>
                                                <input
                                                    type="file"
                                                    class="d-none"
                                                    accept="image/*"
                                                    @change="onFileChange"
                                                />
                                            </label>
                                            <span class="text-danger">{{ form.errors.avatar }}</span>
                                        </div>

                                        <!-- CONFIRM BUTTON -->
                                        <button
                                            v-if="hasImage"
                                            class="btn btn-primary w-100 py-3"
                                            :disabled="form.processing"
                                        >
                                            {{ form.processing ? 'Submitting...' : 'Confirm' }}
                                        </button>
                                    </form>
                        
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
                                                    <b>Food orders from:</b>
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
                                                    <b>Order ID:</b>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <h6>{{ capitalizeFirst(OrderData.order_key ?? '') }}</h6>
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
                                                <h6>{{ capitalizeFirst(storData.translationforvuepage?.stor_name || storData.cuisine) }}</h6>
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

                            <div class="row align-items-stretch">
                                <div class="col-8">
                                    <button class="btn btn-primary px-2 py-2 text-white mb-4 ms-4 w-100">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="btn-text">
                                                {{ $page.props.translations['Total net (including tax)'] }}
                                            </span>
                                            <span class="fw-bold">
                                                {{ currencyData.currency_symbol ?? '' }}
                                                {{ OrderData.totalPayAmount ?? '' }}
                                            </span>
                                        </div>
                                    </button>

                                </div>
                                <div class="col-4 d-flex">
                                    <button class="btn btn-danger px-2 py-2 text-white mb-4 ms-4 w-100">
                                        {{ $page.props.translations['Cancel'] }}
                                    </button>
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



