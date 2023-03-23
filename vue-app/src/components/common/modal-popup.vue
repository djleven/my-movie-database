<template>
  <div class="appModal" v-if="showModal">
    <div class="appModalTitle">
      {{ title }}
      <button class="close" @click="closeModal()">&times;</button>
    </div>
    <div class="appModalBody">
      <p> {{ message }}</p>
    </div>
    <div class="appModalFooter">
      <button class="btn btn-primary" @click="closeModal()">Ok</button>
    </div>
  </div>

</template>
<script setup lang="ts">
const props = defineProps({
  showModal: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    required: true
  },
  message: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['closeModal'])
const closeModal = () => {
  emit('closeModal')
}
</script>
