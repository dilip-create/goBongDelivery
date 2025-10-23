<script setup>
import { usePage } from '@inertiajs/vue3'
  const page = usePage()
</script>

<template>
  <Head title="- Dashboard" />
  <div>
    <h1>Dashboard page</h1>
    <h2 style="color:green">{{ $page.props.flash?.greet }}</h2>
    {{ page.props.auth.user }}
    <img :src="$page.props.auth?.user?.role ? ('storage/' + $page.props.auth?.user?.role) : ('website/assets/logo/logo1.jpg')"  height="200px" width="500px"/>
  </div>
</template>
