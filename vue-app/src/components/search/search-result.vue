<template>
  <credit-item
      :credit="result"
      :column-class="ImageType.Rectangular"
      :image-size="Sizes.Medium"
      :has-set-active-events="true"
  >
    <template #active-slot-content v-if="hasContentSlot">
      <div class="known-for">
        <div class="known-for-department">
          {{ $t('known_for_department') }}
          <span v-if="result.known_for_department">{{result.known_for_department}}</span>
        </div>
        <div v-if="knownFor" class="screenplays">{{ knownFor }}</div>
      </div>
    </template>
    <template #active-slot-after>
      <div
          class="button-primary"
          @click="select()">
        Select
      </div>
    </template>
    <li class="bold center-text">TMDb ID: {{ result.id }}</li>
  </credit-item>
</template>
<script setup lang="ts">
import { computed, inject } from 'vue'
import { ImageType } from '@/helpers/images'
import { Sizes } from '@/models/settings'
import { getExcerpt } from "@/helpers/templating";

const $t = inject('$t')
const props = defineProps({
  result: {
    type: Object,
    required: true
  },
})

const emit = defineEmits([ 'select'])

const select = () => {
  emit('select', props.result.id)
}

const knownFor = computed(() => {
  const known_for = props.result.known_for
  if(known_for && known_for.length) {
    let results: string[] = []
     known_for.forEach((elem) => {
      const text = (elem.name || elem.title)
      if(text) {
        results.push(getExcerpt(text, 35))
      }
    })

    return results.join(", ")
  }
  return null
})

const hasContentSlot = computed(() => {
  return knownFor.value || props.result.known_for_department
})
</script>
