<template>
  <component :is="componentName" />
</template>
<script>
export default {
  props: {
    componentName: {
      type: String,
      required: true,
    }
  },
}
</script>