<script setup>
    import { usePage } from '@inertiajs/vue3'
    const page = usePage()
    const  props  = usePage()
    import { useForm } from '@inertiajs/vue3'
    // add dynamic input field components Satrt
    import  TextInput  from '../../Components/TextInput.vue'
     // add dynamic input field components END
     
    const form = useForm({
        // name: null,
        phoneNumber: null,
        // email: null,
        password: null,
       
    })

    const submit = () => {
        form.post(route('customerLogin'), {
            onError: () => form.reset('password')
        });
        console.log(form);
    }
</script>
<template>
<Head title="- Account">
</Head>
<!-- Checkout Page Start --><br/><br/><br/>
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">My {{ $page.props.translations.Account  }} {{ $page.props.auth.customer.phoneNumber }}</h1>
                <form action="#">
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-6 offset-md-3">
                            
                            <div class="form-item">
                                <!-- <label class="form-label my-3">Name<sup>*</sup></label> -->
                                <TextInput v-model="form.name" :message="form.errors.name" :placeholder="$page.props.translations['Enter Guest name']"  :maxlength="10" :value="$page.props.auth.customer.name"/> 
                                
                            </div>
                            
                            <div class="form-item">
                                <!-- <label class="form-label my-3">Mobile<sup>*</sup></label> -->
                                <TextInput v-model="form.phoneNumber" :message="form.errors.phoneNumber" :placeholder="$page.props.translations['Enter phone number']"  :maxlength="10" :value="$page.props.auth.customer.name"/> 
                            </div>
                            <hr>

                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="button" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                            </div>
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->
</template>
