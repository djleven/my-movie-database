<template>
  <input @keyup="debounce" type="text" v-model="value">
</template>
<script setup lang="ts">
import { ref } from 'vue'

const emit = defineEmits([ 'output'])
const emitOutput = () => {
  emit('output', outputValue.value)
}

const value = ref('')
const outputValue = ref('')
const timeout = ref(0)

const debounce = () => {
  clearTimeout(timeout.value);

  timeout.value = setTimeout( () => {
    outputValue.value = value.value;
    emitOutput()
  }, 1000);
}

</script>