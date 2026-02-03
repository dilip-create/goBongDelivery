<template>
   <div class="container-fluid fruite">
            <div class="container">
                
                    <div class="category-carousel">
                        
                        <div class="category-grid">
                            <div v-for="(category, index) in visibleCategories" :key="index" class="category-item" @click="goToCategory(category.name)">
                                <div class="category-circle">
                                    <img :src="category.image" :alt="category.name">
                                </div>
                                <p class="category-name">{{ category.name }}</p>
                            </div>
                        </div>
                        
                    </div>
                     
            </div>
        </div>
</template>

<script>
 import { usePage } from '@inertiajs/vue3'
    const page = usePage()
    const t = (key, fallback = key) => {
        return page.props.translations?.[key] ?? fallback
    }
    


export default {
  name: 'CategoryCarousel',
  data() {
    return {
      currentIndex: 0,
      categories: [
        // Page 1 (8 items)
        { name: 'All', image: '/website/assets/img/categories/all1.jpg' },
        { name: t('New&Pro'), image: '/website/assets/img/categories/new-arrival.jpg' },
        { name: t('Topped-chicken'), image: '/website/assets/img/categories/topped-chicken.jpg' },
        { name: t('Fast Food'), image: '/website/assets/img/categories/fastfood.gif' },
        { name: t('Water & snacks'), image: '/website/assets/img/categories/water-snack.jpg' },
        { name: t('Isaan pork thai'), image: '/website/assets/img/categories/issan-food2.jpg' },
        { name: t('Laundry'), image: '/website/assets/img/categories/laundry.png' },
        { name: t('Admin'), image: '/website/assets/img/categories/admin.jpg' },
        
        // Page 2 (8 items)
        { name: 'All', image: '/website/assets/img/categories/all1.jpg' },
        { name: t('New&Pro'), image: '/website/assets/img/categories/super-promo.jpg' },
        { name: t('Noodle'), image: '/website/assets/img/categories/noodle.jpg' },
        { name: t('Fast Food'), image: '/website/assets/img/categories/fastfood.gif' },
        { name: t('Water & snacks'), image: '/website/assets/img/categories/water-snack.jpg' },
        { name: t('Isaan pork thai'), image: '/website/assets/img/categories/food-issan.jpg' },
        { name: t('Laundry'), image: '/website/assets/img/categories/laundry.png' },
        { name: t('Admin'), image: '/website/assets/img/categories/admin.jpg' },
         // Page 3 (8 items)
        { name: 'All', image: '/website/assets/img/categories/all2.png' },
        { name: t('New&Pro'), image: '/website/assets/img/categories/new-arrival.jpg' },
        { name: t('Noodle'), image: '/website/assets/img/categories/noodle.jpg' },
        { name: t('Fast Food'), image: '/website/assets/img/categories/fastfood.gif' },
        { name: t('Water & snacks'), image: '/website/assets/img/categories/drink.jpg' },
        { name: t('Isaan pork thai'), image: '/website/assets/img/categories/issan-food2.jpg' },
        { name: t('Laundry'), image: '/website/assets/img/categories/laundry.png' },
        { name: t('Admin'), image: '/website/assets/img/categories/admin.jpg' },
         // Page 4 (8 items)
        { name: 'All', image: '/website/assets/img/categories/all3.jpg' },
        { name: t('New&Pro'), image: '/website/assets/img/categories/super-promo.jpg' },
        { name: t('Topped-chicken'), image: '/website/assets/img/categories/topped-chicken.jpg' },
        { name: t('Fast Food'), image: '/website/assets/img/categories/fastfood.gif' },
        { name: t('Water & snacks'), image: '/website/assets/img/categories/drink.jpg' },
        { name: t('Isaan pork thai'), image: '/website/assets/img/categories/food-issan.jpg' },
        { name: t('Laundry'), image: '/website/assets/img/categories/laundry.png' },
        { name: t('Admin'), image: '/website/assets/img/categories/admin.jpg' },
      ],
      autoChangeInterval: null,
      itemsPerPage: 8
    }
  },
  computed: {
    visibleCategories() {
      const start = this.currentIndex;
      const end = start + this.itemsPerPage;
      return this.categories.slice(start, end);
    }
  },
  mounted() {
    this.startAutoChange();
  },
  beforeUnmount() {
    this.stopAutoChange();
  },
  methods: {
    startAutoChange() {
      // Auto change every 3 seconds
      this.autoChangeInterval = setInterval(() => {
        this.nextPage();
      }, 3000);
    },
    stopAutoChange() {
      if (this.autoChangeInterval) {
        clearInterval(this.autoChangeInterval);
      }
    },
    nextPage() {
      this.currentIndex += this.itemsPerPage;
      // Loop back to start
      if (this.currentIndex >= this.categories.length) {
        this.currentIndex = 0;
      }
    },
    goToCategory(name) {
      const encoded = btoa(unescape(encodeURIComponent(name))) // safe base64
      window.location.href = `/stores/${encoded}`
    }

  }
}
</script>

<style scoped>
.category-carousel {
  padding: 20px;
  background-color: #fff;
}

.category-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(2, 1fr);
  gap: 15px;
}

.category-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  transition: transform 0.2s;
}

.category-item:hover {
  transform: scale(1.05);
}

.category-circle {
  width: 150px;
  height: 130px;
  border-radius: 50%;
  overflow: hidden;
  /* border: 2px solid #ddd; */
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
}

.category-circle img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.category-name {
  font-size: 14px;
  color: #333;
  text-align: center;
  margin: 0;
  font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
  .category-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
  }
  
  .category-circle {
    width: 60px;
    height: 60px;
  }
  
  .category-name {
    font-size: 12px;
  }
}

@media (max-width: 480px) {
  .carousel-container {
    padding: 15px;
  }
  
  .category-circle {
    width: 50px;
    height: 50px;
  }
  
  .category-name {
    font-size: 11px;
  }
}
</style>