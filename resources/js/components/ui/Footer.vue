<template>
  <div class="footer">
    <div class="container">
      <p>&copy; {{year}} QuickFrame 
        <b v-if="loading">Loading...</b>
        <b v-else-if="error">{{ error }}</b>
        <b v-else>v{{frameworkVersion}}</b>
         by PierrOwO. MIT License. <a href="https://github.com/PierrOwO/quickframe">GitHub</a>
      </p>
    </div>
  </div>
</template>

<script setup>

defineProps({
  year: {
    type: Number,
    default: 2025
  },
});
import {ref, onMounted} from 'vue'

import {useFramework} from '../../composables/useFramework';
const { frameworkAuthor, frameworkName, frameworkVersion, loading, error, fetchFrameworkData } = useFramework();

onMounted(async () => {
    await fetchFrameworkData();  
    
});

</script>

<style scoped>
.footer {
  height: 50px;
  background-color: #0056b3;
  color: #fff;
  text-align: center;
}
.footer a{
  color: white;
}
</style>