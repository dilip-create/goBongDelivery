 <script setup>
//   import { Link, Head } from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3'
  const page = usePage()
</script>
<style scoped>
        .red{
            border-color:red;
            color: red;
        }
</style>
<template>
  <div>
    <h1>Login & Register Layouts</h1>
        <header>
            <nav>
                 <Link :href="route('home')" :class="{'red' : $page.component === 'Home'}">Home</Link> || 

                <div v-if="$page.props.auth.user">
                     <Link :href="route('dashboard')" :class="{'red' : $page.component === 'Dashboard'}">Dashboard</Link> ||
                     <Link :href="route('logout')" method="post" as="button" type="button">Logout</Link> 
                </div>
               
                <div v-else>
                    <Link :href="route('register')" :class="{'red' : $page.component === 'Auth/Register'}">Register</Link> || 
                    <Link :href="route('login')" :class="{'red' : $page.component === 'Auth/Login'}">Login</Link>  ||
                </div>
                
            </nav>
        </header>
        <main>
            <slot/>
        </main>
  </div>
</template>