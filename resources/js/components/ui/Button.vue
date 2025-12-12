<script setup>
const props = defineProps({
  theme: {
    type: String,
    default: 'default' 
  }
})

const styleMap = {
  red: 'button btn-red',
  blue: 'button btn-blue',
  green: 'button btn-green',
  big: 'btn-big',
  default: 'button btn-blue',
}
</script>
<template>
    <button @click="$emit('trigger-action')" :class="styleMap[props.theme]">
      <slot>button</slot>
    </button>
</template>
<style scoped>
.btn-big{
   font-size: 24px;
   padding: 10px;
   border-radius: 14px;
   box-shadow: rgba(0, 0, 0, 0.24) 0px 13px 8px;
   border:1px solid rgb(200, 200, 200);
   background-color: white;
   transition: 0.2s;
   cursor: pointer;
}
.btn-big:active{
    scale: 0.99;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    border:1px solid rgb(200, 200, 200);
    background-color: white;
    transition: 0.4s;
 }
.button{
  min-height: 30px;
  min-width: 80px;
  background-color: gray;
  border: none;
  border-radius: 5px;
  font-weight: 600;
  transition: 0.15s;
  cursor: pointer;
  display: block;
  box-sizing: border-box;
}
.btn-red {
  background-color: rgb(232, 61, 61);
  color: rgb(88, 24, 24);
}
.btn-red:hover {
  background-color: rgb(234, 112, 112);
}
.btn-red:active {
  background-color: rgb(195, 92, 92);
}
.no-hover-red,
.no-hover-red:hover{
  background-color: rgb(232, 61, 61);
  color: rgb(88, 24, 24);
  cursor: default;
  pointer-events: none;
}

.btn-green {
  color: rgb(18, 71, 18);
  background-color: rgb(82, 218, 82);
}
.btn-green:hover {
  background-color: rgb(126, 238, 126);
}
.btn-green:active {
  background-color: rgb(110, 197, 110);
}
.no-hover-green,
.no-hover-green:hover{
  color: rgb(18, 71, 18);
  background-color: rgb(82, 218, 82);
  cursor: default;
  pointer-events: none;
}

.btn-blue {
  color: rgb(166, 199, 255);
  background-color: rgb(55, 117, 219);
}
.btn-blue:hover {
  background-color: rgb(87, 135, 213);
}
.btn-blue:active {
  background-color: rgb(78, 115, 174);
}
.no-hover-blue,
.no-hover-blue:hover{
  color: rgb(166, 199, 255);
  background-color: rgb(55, 117, 219);
  cursor: default;
  pointer-events: none;
}
</style>