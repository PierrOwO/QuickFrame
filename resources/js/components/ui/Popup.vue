<template>
  <div 
    class="popup" 
    v-show="isVisible" 
    :class="{ openPopupAnimation: opening, closePopupAnimation: closing }"
    ref="popup"
  >
    <div 
      class="content" 
      :class="{ openPopupContentAnimation: opening, closePopupContentAnimation: closing }"
      ref="popupContent"
    >
      <div class="body">
        <span class="message" ref="messageSpan" v-html="props.message"></span>
        <slot></slot>
      </div>
      <div class="footer">
        <button v-show="isConfirmAlert" :class="'btn-confirm-1'" @click="$emit('confirm')">Accept</button>
        <button v-show="isInfoAlert" :class="'btn-okay'" @click="okay">Okay</button>
        <button v-show="isConfirmAlert" :class="'btn-confirm-2'" @click="$emit('cancel')">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isVisible = ref(false);
const opening = ref(false);
const closing = ref(false);
const isInfoAlert = ref(false)
const isConfirmAlert = ref(false)

const props = defineProps({
  message: {
    type: String,
    default: 'test Message',
  },
  type: {
    type: String,
  }
});
const popup = ref(null);
const popupContent = ref(null);
const messageSpan = ref(null)

function setType() {
  isInfoAlert.value = props.type === 'info'
  isConfirmAlert.value = props.type === 'confirm'
}
function openPopup() {
  setType();
  isVisible.value = true;
  opening.value = true;

  setTimeout(() => {
    opening.value = false;
  }, 400);
}

function closePopup() {
  closing.value = true;

  setTimeout(() => {
    closing.value = false;
    isVisible.value = false;
    isConfirmAlert.value = false;
    isConfirmAlert.value = false;
  }, 400);
}

function accept() {
  closePopup();
}

function cancel() {
  closePopup();
}

function okay() {
  closePopup();
}

onMounted(() => {
 // messageSpan.value.textContent = props.message;
  //messageSpan.value.html = props.message

})
defineExpose({ openPopup,closePopup });

</script>

<style scoped>
.popup{
    background-color: rgba(0, 0, 0, 0.3);
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.4s;
    z-index: 100000;
}
.popup .content {
    width: 400px;
    min-height: 150px;
    background-color: white;
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    transition: 0.4s;
}
.popup .content .body{
    min-height: 100px;
    width: 100%;
    position: relative;
}
.popup .content .body .message{
    position: absolute;
    top:50%;
    left:50%;
    transform: translate(-50%,-50%);
    width: 80%;
    text-align: center;
    font-size: large;
}
.popup .content .footer{
    border-top: 1px solid gray;
    height: 50px;
    background-color: white;
    position: relative;
    line-height: 50px;
}
.popup .content .footer button {
    height: 30px;
    width: 80px;
    background-color: gray;
    border: none;
    border-radius: 5px;
    position: absolute;
    top:50%;
    transform: translateY(-50%);
    font-weight: 600;
    transition: 0.15s;
    cursor: pointer;
}
.popup .content .footer .btn-confirm-1{
    left: 12.5px;
    color: rgb(18, 71, 18);
    background-color: rgb(82, 218, 82);
}
.popup .content .footer .btn-confirm-1:hover{ background-color: rgb(126, 238, 126); }
.popup .content .footer .btn-confirm-1:active{ background-color: rgb(110, 197, 110); }

.popup .content .footer .btn-okay{
    color: rgb(15, 49, 104);
    background-color: rgb(55, 117, 219);
    left:50%;
    top:50%;
    transform: translate(-50%, -50%);
}
.popup .content .footer .btn-okay:hover{ background-color: rgb(87, 135, 213); }
.popup .content .footer .btn-okay:active{ background-color: rgb(78, 115, 174); }

.popup .content .footer .btn-confirm-2{
    right: 12.5px;
    background-color: rgb(232, 61, 61);
    color: rgb(88, 24, 24);
}
.popup .content .footer .btn-confirm-2:hover{ background-color: rgb(234, 112, 112); }
.popup .content .footer .btn-confirm-2:active{ background-color: rgb(195, 92, 92); }
.popup .content .footer .hidden-button {
  opacity: 0;
  z-index: 99999;
}
/* animations */
@keyframes openPopup {
    from{ background-color: rgba(0, 0, 0, 0); }
    to{ background-color: rgba(0, 0, 0, 0.3); }
}
@keyframes closePopup {
    from{ background-color: rgba(0, 0, 0, 0.3); }
    to{ background-color: rgba(0, 0, 0, 0); }
}
@keyframes openPopupContent {
    from{ margin-top: -200px; opacity: 0; }
    to{ margin-top: 0; opacity: 1; }
}
@keyframes closePopupContent {
    from{ margin-top: 0; opacity: 1; }
    to{ margin-top: -50px; opacity: 0; }
}
.openPopupAnimation { animation: openPopup 0.3s forwards; }
.closePopupAnimation { animation: closePopup 0.5s forwards; }
.openPopupContentAnimation { animation: openPopupContent 0.4s forwards; }
.closePopupContentAnimation { animation: closePopupContent 0.4s forwards; }
</style>