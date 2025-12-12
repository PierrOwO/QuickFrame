<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  modelValue: String
})
const emit = defineEmits(['update:modelValue'])

function updateValue(e) {
  emit('update:modelValue', e.target.value)
}
</script>

<template>
  <input
    :value="modelValue"
    @input="updateValue"
    type="text"
  />
</template>
<style scoped>
input{
  display: block;
  height: 28px;
  min-width: 80px;
  border: 1px solid gray;
  border-radius: 5px;
  box-sizing: border-box;
}
</style>