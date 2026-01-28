<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const images = [
   '/website/assets/img/banners/small-banner-1.png',
    '/website/assets/img/banners/small-banner-2.png',
]

const activeIndex = ref(0)
let timer = null

onMounted(() => {
    timer = setInterval(() => {
        activeIndex.value =
            (activeIndex.value + 1) % images.length
    }, 4000)
})

onUnmounted(() => clearInterval(timer))
</script>

<style>
.banner-wrapper {
    position: relative;
    width: 100%;
    height: 170px;
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    margin: 20px 0;

    /* shadow exactly like app */
    /* box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25); */
}

/* ALL images stacked */
.banner-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;

    object-fit: cover;          /* 🔥 FULL COVER */
    object-position: center;

    opacity: 0;
    transition: opacity 0.8s ease-in-out;
}

/* only active visible */
.banner-image.active {
    opacity: 1;
}

/* desktop fix */
@media (min-width: 1024px) {
    .banner-wrapper {
        height: 240px;
    }
}

</style>
<template>
   
     <div class="container-fluid fruite">
            <div class="container">
                <div class="tab-class text-center">
                    <div class="banner-wrapper">
                        <img
                            v-for="(img, i) in images"
                            :key="img"
                            :src="img"
                            class="banner-image"
                            :class="{ active: i === activeIndex }"
                        />
                    </div>
                </div>      
            </div>
        </div>
</template>

