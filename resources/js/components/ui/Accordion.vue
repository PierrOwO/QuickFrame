<template>
  <div class="accordion">
    <div class="head" @click="toggle">
      <span>{{ title }}</span>
      <i :class="{ rotate: isOpen }">⌵</i>
    </div>

    <div class="body" :style="{ maxHeight: isOpen ? bodyScrollHeight + 'px' : '0px' }" ref="bodyRef">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
  title: {
    type: String,
    default: 'title'
  },
  modelValue: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['update:modelValue']);
const isOpen = ref(props.modelValue);
const bodyRef = ref(null);
const bodyScrollHeight = ref(0);

const toggle = () => {
  emit('update:modelValue', !isOpen.value);
};

watch(() => props.modelValue, (val) => {
  isOpen.value = val;
});

onMounted(() => {
  bodyScrollHeight.value = bodyRef.value.scrollHeight;
});
</script>

<style scoped>
.accordion {
  border-bottom: 1px solid rgba(255,255,255,0.2);
}

.head {
  display: flex;
  justify-content: space-between;
  padding: .8rem 0;
  cursor: pointer;
  font-size: 1.1rem;
}

.head i {
  transition: .3s;
}
.head i.rotate {
  transform: rotate(180deg);
}

.body {
  overflow: hidden;
  transition: max-height .35s ease;
  padding-left: .5rem;
}
@media (max-width: 1000px) {
  .accordion {
    font-size: 2rem;
  }

  .accordion .head {
    font-size: 2rem;
    padding: 1rem 0;
  }

  .accordion .body {
    padding-left: 1rem;
  }
}
</style>