<template>
     <div class="container-fluid vesitable">
            <div class="container py-5">
                <h2 class="mb-0">📌{{ $page.props.translations['Recommended shops'] }}</h2>
                <div class=" justify-content-center">
                    
                      <div class="carousel-viewport" @mouseenter="pauseAutoplay" @mouseleave="resumeAutoplay">
                        <!-- sliding track -->
                        <div class="carousel-track" :style="{ transform: `translateX(-${(currentIndex * 100) / itemsPerView}%)` }">
                          <div v-for="(stor, i) in recommendedstors" :key="stor.id ?? i" class="card">
                            <a href="#ddddd">
                            <div class="card-image">
                              <img :src="stor.stor_photo ? `/storage/${stor.stor_photo}` : placeholder" alt="" />
                            </div>
                            </a>
                            <div class="text-white bg-primary rounded position-absolute popular-promotion-trip" >Promotion</div>
                            <div class="card-body">
                              <span class="badge">{{ stor.stor_type ? $page.props.translations[stor.stor_type] : '' }}</span>
                             
                                                           
                                  <div class="d-flex justify-content-between flex-lg-wrap">
                                      <p class="text-dark  mb-0">{{ stor.distance_from_office ? stor.distance_from_office+' '+$page.props.translations.km : '' }}</p>
                                      <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                  </div>
                                  <div class="d-flex justify-content-between flex-lg-wrap">
                                      <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ stor.distance_from_office < 1 ? $page.props.translations['Free shipping'] : '20 bhat' }}</p>
                                      <p>{{ stor.cuisine ? $page.props.translations[stor.cuisine] : '' }}</p>
                                  </div>
                                      <p>{{ $page.props.translations['Opening hours'] }}:{{ stor.opentime ? formatTime(stor.opentime) : '' }}-
                                      {{ stor.closetime ? formatTime(stor.closetime) : '' }}</p>
                                               
                             
                            </div>

                          </div>
                        </div>
                        <!-- nav -->
                        <button class="nav prev" @click="prev">‹</button>
                        <button class="nav next" @click="next">›</button>
                      </div> 
                </div>
            </div>
        </div>
</template>

<script setup>
import  webloyout from "@/Layouts/Weblayout.vue";
    defineOptions({ layout: webloyout });
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  recommendedstors: {
    type: Array,
    default: () => [],
  },
})

const itemsPerViewDesktop = 4
const itemsPerViewMobile = 2

const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1200)
const itemsPerView = ref(windowWidth.value < 768 ? itemsPerViewMobile : itemsPerViewDesktop)

const currentIndex = ref(0)
const placeholder = '/images/placeholder.png'

function handleResize() {
  windowWidth.value = window.innerWidth
  itemsPerView.value = windowWidth.value < 768 ? itemsPerViewMobile : itemsPerViewDesktop
  const maxIndex = Math.max(0, props.recommendedstors.length - itemsPerView.value)
  if (currentIndex.value > maxIndex) currentIndex.value = maxIndex
}

if (typeof window !== 'undefined') {
  window.addEventListener('resize', handleResize)
}

function next() {
  const maxIndex = Math.max(0, props.recommendedstors.length - itemsPerView.value)
  currentIndex.value = currentIndex.value >= maxIndex ? 0 : currentIndex.value + 1
}
function prev() {
  const maxIndex = Math.max(0, props.recommendedstors.length - itemsPerView.value)
  currentIndex.value = currentIndex.value <= 0 ? maxIndex : currentIndex.value - 1
}
function goTo(i) {
  currentIndex.value = i * itemsPerView.value
}

const totalDots = computed(() =>
  Math.ceil(props.recommendedstors.length / itemsPerView.value)
)
const currentDot = computed(() =>
  Math.floor(currentIndex.value / itemsPerView.value)
)

// autoplay
let autoplayTimer = null
const autoplayMs = 3000
function startAutoplay() {
  stopAutoplay()
  autoplayTimer = setInterval(() => next(), autoplayMs)
}
function stopAutoplay() {
  if (autoplayTimer) {
    clearInterval(autoplayTimer)
    autoplayTimer = null
  }
}
function pauseAutoplay() {
  stopAutoplay()
}
function resumeAutoplay() {
  if (props.recommendedstors.length > itemsPerView.value) startAutoplay()
}

onMounted(() => {
  if (props.recommendedstors.length > itemsPerView.value) startAutoplay()
})
onBeforeUnmount(() => {
  stopAutoplay()
  if (typeof window !== 'undefined') window.removeEventListener('resize', handleResize)
})

  // Format "HH:mm:ss" → "hh:mm AM/PM" Code START
    const formatTime = (timeString) => {
    if (!timeString) return ''
    const [hour, minute] = timeString.split(':')
    const date = new Date()
    date.setHours(parseInt(hour), parseInt(minute))

    // toLocaleTimeString gives 12-hour time with AM/PM
    return date.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    })
    }
    // Format "HH:mm:ss" → "hh:mm AM/PM" Code END
</script>

<style scoped>
.carousel-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 28px 16px;
  box-sizing: border-box;
}

.title {
  font-size: 28px;
  margin-bottom: 20px;
  color: #2f4f4f;
}

.carousel-viewport {
  position: relative;
  overflow: hidden;
  background: transparent;
  padding: 10px 0;
}

.carousel-track {
  display: flex;
  transition: transform 450ms cubic-bezier(.2,.9,.2,1);
  will-change: transform;
}

.card {
  background: #fff;
  border-radius: 8px;
  border: 1px solid #d7ecca;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
}

.card-image {
  width: 100%;
  height: 190px;
  overflow: hidden;
}
.card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.card-body {
  padding: 14px;
  display: flex;
  flex-direction: column;
  flex: 1 1 auto;
}
.badge {
  display:inline-block;
  background:#6fc22a;
  color:#fff;
  padding:4px 8px;
  border-radius: 999px;
  font-size:12px;
  text-transform:capitalize;
}
.nav {
  position:absolute;
  top:50%;
  transform:translateY(-50%);
  width:44px;
  height:44px;
  border-radius:50%;
  background:white;
  border:1px solid #cfecc2;
  font-size:22px;
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  box-shadow:0 2px 6px rgba(0,0,0,0.06);
}
.nav.prev { left:8px }
.nav.next { right:8px }

.dots {
  margin-top:12px;
  display:flex;
  gap:8px;
  justify-content:center;
}
.dot {
  width:10px;height:10px;border-radius:50%;background:#e6e6e6;border:none;cursor:pointer;
}
.dot.active { background:#7cc22a }

@media (min-width: 768px) {
  .carousel-track { gap: 22px; }
  .card { flex: 0 0 calc((100% - 3 * 22px) / 4); }
}
@media (max-width: 767px) {
  .carousel-track { gap: 12px; } /* optional smaller gap */
  .card { flex: 0 0 calc((100% - 12px) / 2); } /* two items per view */
  .card-image { height: 200px; }
}
</style>
