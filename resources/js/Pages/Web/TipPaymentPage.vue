<script setup>
    import { ref } from 'vue'
    import { usePage } from '@inertiajs/vue3'
    const page = usePage()
    const t = (key, fallback = key) => {
        return page.props.translations?.[key] ?? fallback
    }

    const props = defineProps({
    OrderData: Array,
    tipAmount: Object,
    tipDesc: Array,
    currencyData: Array,
    })
   
   // submit file upload form with showing processing images code START
    const preview = ref(null)
    const file = ref(null)
    const hasImage = ref(false)

    const loading = ref(false)
    const processing = ref(false)
    const success = ref(false)
    const error = ref(null)

    function onFileChange(e) {
        const selected = e.target.files[0]
        if (!selected) return

        file.value = selected
        preview.value = URL.createObjectURL(selected)
        hasImage.value = true
        error.value = null
    }

    const encodedOrderKey = base64Encode(props.OrderData.order_key);
    async function submit() {
        if (!file.value) {
            error.value = 'Please select an image'
            return
        }

        loading.value = true

        const formData = new FormData()
        formData.append('avatar', file.value)
        formData.append('order_key', props.OrderData.order_key)
       
        try {
            await axios.post('/save/tipPaymentslip', formData)
            success.value = true
            processing.value = true
            setTimeout(() => {
                window.location.href = route(
                    'myOrder.orderDetails',
                    { orderKey: encodedOrderKey }
                )
            }, 6000)
        } catch (e) {
            error.value =
                e.response?.data?.message || 'Something went wrong'
        } finally {
            loading.value = false
        }
    }
    // submit file upload form with showing processing images code START

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

    function base64Encode(value) {
        return window.btoa(String(value));
    }
</script>

<template>
    <Head :title="`- ${$page.props.translations['Make payment']}`" />
         
        <!-- Fruits Shop Start--><br/><br/><br/><br/>
        <div class="container-fluid fruite py-5">
            <div class="container bg-light p-2 rounded py-1">
                <div class="order-header d-flex align-items-center">
                    <!-- Back button -->
                        <Link :href="`/myOrder/orderDetails/${encodedOrderKey}`"><button class="btn back-btn me-3"><i class="fas fa-arrow-left"></i></button></Link>
                    <div class="text-center flex-grow-1">
                        <h5 v-if="success" class="mb-0 text-white fw-semibold">{{ $page.props.translations['Thank you'] ?? '' }} !</h5>
                        <h5 v-else class="mb-0 text-white fw-semibold"> {{ $page.props.translations['Make Tips payment'] ?? '' }} {{ currencyData.currency_symbol ?? '' }}{{ props.tipAmount }}</h5>
                    </div>
                </div>

                <!-- UPLOAD + CONFIRM SECTION -->
                <!-- SUCCESS ALERT -->
                <div v-if="success" class="alert alert-success mb-4 text-center">
                    <strong>{{ $page.props.translations['Confirmation successful'] ?? '' }}!</strong>
                    <!-- <br />
                    {{ $page.props.translations['The system is now processing your request'] ?? '' }}. -->
                </div>

                <!-- PROCESSING VIEW -->
                <div v-if="processing" class="text-center">
                    <img :src="`${$page.props.appUrl}/website/assets/img/banners/step4.png`" class="img-fluid mb-3" style="max-width:300px;">
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
                                    <div v-if="hasImage && !processing" class="mb-3 text-center">
                                        <img :src="preview" class="img-fluid rounded shadow" style="max-height:350px;"/>
                                    </div>
                                    <!-- UPLOAD + CONFIRM -->
                                    <form v-if="!processing" @submit.prevent="submit">
                                        <!-- Upload button -->
                                        <div class="mb-4">
                                            <label class="w-100">
                                                <div class="btn btn-primary w-100 py-3">
                                                    {{ $page.props.translations['Attach the tips confirmation slip'] }}
                                                </div>
                                                <input type="file" class="d-none" accept="image/*" @change="onFileChange"/>
                                            </label>
                                            <span class="text-danger">{{ error }}</span>
                                        </div>
                                        <!-- Confirm button -->
                                        <button v-if="hasImage" class="btn btn-primary w-100 py-3" :disabled="loading">
                                            {{ loading ? 'Submitting...' : 'Confirm' }}
                                        </button>
                                    </form>


                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->
      
</template>



