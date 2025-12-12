<script setup>
    import { ref, onMounted, onBeforeUnmount } from 'vue'
    
    const visible = ref(false)
    
    function handleScroll() {
      visible.value = window.scrollY > 300
    }
    
    function scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      })
    }
    
    onMounted(() => {
      window.addEventListener('scroll', handleScroll)
    })
    
    onBeforeUnmount(() => {
      window.removeEventListener('scroll', handleScroll)
    })
    </script>
    
    <template>
      <button 
        v-if="visible"
        class="back-to-top"
        @click="scrollToTop"
      >
        ↑ Top
      </button>
    </template>
    
    <style scoped>
    .back-to-top {
      position: fixed;
      right: 25px;
      bottom: 25px;
      padding: 12px 18px;
      font-size: 16px;
      font-weight: 600;
      background: #111;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      opacity: 0.8;
      transition: 0.2s ease;
      z-index: 999;
    }
    
    .back-to-top:hover {
      opacity: 1;
    }
    </style>