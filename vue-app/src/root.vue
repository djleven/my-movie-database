<template>
  <component v-if="componentName"
             :is="componentName"
  />
</template>
<script>
export default {
  props: {
    componentName: {
      type: String,
      default: null,
    }
  },
}
</script>