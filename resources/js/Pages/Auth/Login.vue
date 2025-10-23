<script setup>
    // add register layout Satrt
    import  demoloyout from "../../Layouts/demoloyout.vue";
    defineOptions({ layout: demoloyout });
    // add register layout END
    import { useForm } from '@inertiajs/vue3'
    // add dynamic input field components Satrt
    import  TextInput  from '../Components/TextInput.vue'
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
<template>
<Head title="- Login Form">
</Head>
<div>
    <h1> Login to your Account </h1>
    <form @submit.prevent="submit">

      <!-- <TextInput name="Name" v-model="form.name" :message="form.errors.name" /> -->
      <TextInput name="Phone Number" v-model="form.phoneNumber" :message="form.errors.phoneNumber" /> 
      <!-- <TextInput name="Email" type="email" v-model="form.email" :message="form.errors.email" /> -->
    
      <TextInput name="Password" type="password" v-model="form.password" :message="form.errors.password" />
     
        <div>
            <p>No have account register ?
                <Link :href="route('register')">Register</Link>
            </p>
        </div>
        <button class="btn btn-primary" :disabled="form.processing">Login</button>
    </form>
</div>
</template>
