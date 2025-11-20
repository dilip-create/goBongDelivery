<script setup>
    import { usePage, useForm } from '@inertiajs/vue3'
    const page = usePage()
    // const  props  = usePage()
    // add dynamic input field components Satrt
    import  TextInput  from '../../Components/TextInput.vue'
     // add dynamic input field components END
     
   


  
import { ref } from 'vue'

const props = defineProps({
  customer: Object
})

const form = useForm({
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
<style scoped>
.avatar-wrapper {
    width: 130px;
    margin: 0 auto;
    position: relative;
}

.avatar-img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    position: relative;
    cursor: pointer;
    background: #f8f8f8;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Hide file input */
#fileUpload {
    display: none;
}

/* Edit Pen Icon */
.edit-icon {
    position: absolute;
    bottom: 10px;
    right: 5px;
    background: #0055ff;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 17px;
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
</style>

<template>
<Head title="- Account">
</Head>
<!-- Checkout Page Start --><br/><br/><br/>
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">My {{ $page.props.translations.Account  }} {{ $page.props.auth.customer.phoneNumber }}</h1>
                <form @submit.prevent="submit">
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-6 offset-md-3">
                            
                            <div class="avatar-wrapper">

                                <!-- Image Preview -->
                                <div class="avatar-img"
                                    @dragover.prevent
                                    @drop="onDrop">

                                    <img 
                                        v-if="preview" 
                                        :src="preview" 
                                        alt="Profile"
                                    />

                                    <!-- File Input (Hidden) -->
                                    <input 
                                        id="fileUpload"
                                        type="file"
                                        accept="image/*"
                                        @change="selectFile"
                                    />

                                    <!-- Edit Icon -->
                                    <label for="fileUpload" class="edit-icon">
                                        ✎
                                    </label>

                                </div>

                            </div>


                            <div class="form-item">
                                <!-- <label class="form-label my-3">Name<sup>*</sup></label> -->
                                <TextInput v-model="form.name" :message="form.errors.name" :placeholder="$page.props.translations['Enter Guest name']"  :maxlength="10" :value="$page.props.auth.customer.name"/> 
                            </div>
                            
                            <div class="form-item">
                                <!-- <label class="form-label my-3">Mobile<sup>*</sup></label> -->
                                <TextInput v-model="form.phoneNumber" :message="form.errors.phoneNumber" :placeholder="$page.props.translations['Enter phone number']"  :maxlength="10" :value="$page.props.auth.customer.name"/> 
                            </div>

                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button :disabled="form.processing" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Update</button>
                            </div>
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->
</template>
