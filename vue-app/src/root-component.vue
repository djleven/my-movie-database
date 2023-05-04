<template>
  <div>
    <component :is="componentName" />
    <modal-popup
        :show-modal="hasMessageToShow"
        :title="title"
        :message="messageToShow"
        @close-modal="closeModal()"
    />
  </div>

</template>
<script setup lang="ts">
import { computed } from 'vue'
import { useStore } from '@/store'

const props = defineProps({
  componentName: {
    type: String,
    required: true,
  }
})

const title = "Error"
const store = useStore();
const messageToShow = computed(() => store.state.error)
const hasMessageToShow = computed(() => Boolean(messageToShow.value))

function closeModal() {
  store.commit('setErrorMessage', '')
}
</script>