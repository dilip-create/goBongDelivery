<script setup>
    import { useForm } from '@inertiajs/vue3'
    // add dynamic input field components Satrt
    import  TextInput  from '../../Components/TextInput.vue'
     // add dynamic input field components END
     
    import { ref } from 'vue'
    const props = defineProps({
    customer: Object
    })

    const form = useForm({
    id: props.customer.id,
    name: props.customer.name,
    phoneNumber: props.customer.phoneNumber,
    picture: null
    })

    const preview = ref(
    props.customer.picture
        ? `/storage/${props.customer.picture}`
        : `/website/assets/img/customers/avatar.jpg`  // dummy image
    )


    const selectFile = (event) => {
    const file = event.target.files[0]
    if (file) {
        form.picture = file
        preview.value = URL.createObjectURL(file)
    }
    }

    const onDrop = (event) => {
    event.preventDefault()
    const file = event.dataTransfer.files[0]
    if (file) {
        form.picture = file
        preview.value = URL.createObjectURL(file)
    }
    }

    const submit = () => {
    form.post(route('account.update'), {
        forceFormData: true
    })
    }
</script>

<template>
<Head title="- Account">
</Head>
<!-- Checkout Page Start --><br/><br/><br/>
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">My {{ $page.props.translations.Account  }} </h1>
                <form @submit.prevent="submit">
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-6 offset-md-3">
                            
                            <div class="avatar-wrapper">
                                <!-- Image Preview -->
                                <div class="avatar-img" @dragover.prevent @drop="onDrop">
                                    <img v-if="preview" :src="preview" alt="Profile"/>
                                    <!-- File Input (Hidden) -->
                                    <input id="fileUpload" type="file" accept="image/*" @change="selectFile"/>
                                    <label for="fileUpload" class="edit-icon"> ✎ </label>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <!-- <label class="form-label my-3">Name<sup>*</sup></label> -->
                                <TextInput v-model="form.name" :message="form.errors.name" :placeholder="$page.props.translations['Enter Guest name']"  /> 
                            </div>
                            <div class="form-item">
                                <!-- <label class="form-label my-3">Mobile<sup>*</sup></label> -->
                                <TextInput v-model="form.phoneNumber" :message="form.errors.phoneNumber" :placeholder="$page.props.translations['Enter phone number']"  :maxlength="10"/> 
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button :disabled="form.processing" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">{{ $page.props.translations['Update'] }}</button>
                            </div>
                            <h2 class="text-primary text-center">{{ $page.props.flash?.greet }}</h2>
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->
</template>
