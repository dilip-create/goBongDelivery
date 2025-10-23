<script setup>
// add register layout Satrt
    import  demoloyout from "../Layouts/demoloyout.vue";
    defineOptions({ layout: demoloyout });
    // add register layout END
</script>
<template>
  <Head title ="- Home page">
    </Head>
  <Layout>
    <div>
      <h1>Home Page — Hello Laravel + InertiaJS + VueJS</h1>

      <div>PageName: {{ $page.component}}</div>
      
      <Link class="mt-[1000px] block" href="#" preserve-scroll>Submit form btn</Link>
    </div>
  </Layout>
</template>
