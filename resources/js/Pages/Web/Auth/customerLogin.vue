<script setup>
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
        form.post(route('login'), {
            onError: () => form.reset('password')
        });
        console.log(form);
    }
</script>
<style scoped>
.green-color{
   background-color : #00A631;
}
</style>
<template>
<Head title="- Login Form">
</Head>
<div>
     <!-- Contact Start --><br/><br/><br/>
        <div class="container-fluid contact py-5">
            <div class="container py-5"> 
                <div class="p-5 green-color rounded">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center mx-auto" style="max-width: 700px;">
                                <img :src="`${$page.props.appUrl}/website/assets/logo/logo3.jpg`" alt="logo" style="height:100px;width:100px;border-radius:50%"/>
                                <p class="text-white">{{ $page.props.translations['Please enter your phone number for more experiences, happiness and privileges.'] }}</p>
                            </div>
                        </div>
                        <div class="offset-lg-4 col-lg-4">
                            <form @submit.prevent="submit">

                                 <TextInput v-model="form.phoneNumber" :message="form.errors.phoneNumber" :placeholder="$page.props.translations['Enter phone number']"  :maxlength="10"/> 
                                <!-- <input type="text" class="w-100 form-control border-0 py-3 mb-4" placeholder="Your Name"> -->
                                
                                <button class="w-100 btn form-control border-secondary py-3 bg-white text-success" :disabled="form.processing">{{ $page.props.translations['Login'] }} <i class="fa fa-arrow-right"></i></button>
                                <p class="mb-7 text-white">{{ $page.props.translations['No have account'] }} ?
                                    <Link :href="route('/')" class="mb-7 text-secondary" >{{ $page.props.translations['Unregistered'] }}</Link>
                                </p>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

    
</div>
</template>
