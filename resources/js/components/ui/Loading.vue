<template>
  <div 
    class="loading-body"
    v-show="isVisible">
    <div class="spinner"></div>
    <span>Loading</span>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isVisible = ref(false);
const opening = ref(false);
const closing = ref(false);

function startLoading() {
  isVisible.value = true;
  opening.value = true;

  setTimeout(() => {
    opening.value = false;
  }, 400);
}

function stopLoading() {
  closing.value = true;

  setTimeout(() => {
    closing.value = false;
    isVisible.value = false;
  }, 400);
}
defineExpose({ startLoading, stopLoading });

</script>

<style scoped>
  .loading-body {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: #f8f8f8;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }
  .loading-body .spinner {
    width: 40px;
    height: 40px;
    border: 8px solid #ddd;
    border-top-color: #3498db;
    border-radius: 50%;
    animation: spin 0.75s linear infinite;
  }

@keyframes spin{
  to {
    transform: rotate(360deg);
  }
}
</style>