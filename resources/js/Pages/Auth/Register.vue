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
        name: null,
        email: null,
        phoneNumber: null,
        password: null,
        password_confirmation: null,
        avatar: null,
    });

    // const change = (e) => {
    //     form.avatar = e.target.files[0];
    // };

    const submit = () => {
        form.post(route('register'), {
            onError: () => form.reset('password', 'password_confirmation')
        });
        console.log(form);
    };
</script>
<template>
<Head title="- Registration Form">
</Head>
<div>
    <h1> Registration Form </h1>
    <form @submit.prevent="submit">

      <TextInput labelname="Name" v-model="form.name" :message="form.errors.name" />
      <TextInput labelname="Email" type="email" v-model="form.email" :message="form.errors.email" />
      <TextInput labelname="Phone Number" v-model="form.phoneNumber" :message="form.errors.phoneNumber" />
      <TextInput labelname="Password" type="password" v-model="form.password" :message="form.errors.password" />
      <TextInput labelname="Confirm Password" type="password" v-model="form.password_confirmation" :message="form.errors.password_confirmation" />

        <div class="mb-6">
            <label>Avatar</label>
            <!-- <input type="file" id="avatar" @input="change"/> -->
            <input type="file" id="avatar" @input="form.avatar = $event.target.files[0]" />
            <span style="color:red;">{{ form.errors.avatar }}</span>
        </div><br />

        <!-- <div class="mb-6">
            <label>Name</label>
            <input type="text" v-model="form.name" />
            <span style="color:red;">{{ form.errors.name }}</span>
        </div><br />
        <div class="mb-6">
            <label>Email</label>
            <input type="email" v-model="form.email" />
            <span style="color:red;">{{ form.errors.email }}</span>
        </div><br />
        <div class="mb-6">
            <label>Mobile</label>
            <input type="text" v-model="form.phoneNumber" />
            <span style="color:red;">{{ form.errors.phoneNumber }}</span>
        </div><br />
        <div class="mb-6">
            <label>Password</label>
            <input type="text" v-model="form.password" />
            <span style="color:red;">{{ form.errors.password }}</span>
        </div><br />
        <div class="mb-6">
            <label>Confirm Password</label>
            <input type="text" v-model="form.password_confirmation" />

        </div> -->
        <div>
            <p>Already a customer?
                <Link :href="route('login')">login</Link>
            </p>
        </div>
        <button class="btn btn-primary" :disabled="form.processing">Register</button>
    </form>
</div>
</template>
