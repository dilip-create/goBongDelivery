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
    <Head>
        <!-- <title>main Layout title</title> -->
        <meta name="description" content="This is main layout meta decription">
    </Head>
  <div>
     <h1>Main Layouts</h1>
        <header> 
            <h1>Welcome in GO Bong {{ page.props.auth?.user?.name ?? '' }} </h1>
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
            <slot />
        </main>
  </div>
</template>