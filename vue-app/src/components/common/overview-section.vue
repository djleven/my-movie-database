<template>
  <section-layout
      :show-header="showSubSections"
      :header="$t('summary')"
      class-list="overview"
  >
    <div class="mmdb-flex-container">
      <div :class="`meta-wrapper ${store.state.type}`">

        <h1 class="mmodb-title" :style="`color: ${store.state.styling.bodyFontColor}`">
          {{ title }}
        </h1>
        <template v-for="(meta, index) in mainMeta" :key="index">
          <div v-if="showMeta(index, 'mainMeta')" :class="`mmodb-${index}`">
            <strong>{{ meta.label ?? $t(index) }}:</strong>
            {{ meta.value }}
          </div>
        </template>

        <template v-for="(meta, index) in linksMeta" :key="index">
          <div v-if="showMeta(index, 'linksMeta')" :class="`mmodb-${index}`">
            <a target="_blank" :href="meta.value">
              <strong>{{ $t(index) }}</strong>
            </a>
          </div>
        </template>
      </div>
      <div>
        <img class="mmdb-poster"
             :src="getImage"
             :alt="`${title} image`"
        />
      </div>

      <div v-if="store.state.showSettings.overview_text"
           class="overview-text">
        <div>
          {{ description }}
        </div>
      </div>
      <div v-if="bottomMeta" class="mmdb-ownership">
        <template v-for="(meta, index) in bottomMeta" :key="index">
          <div v-if="showMeta(index, 'bottomMeta')" :class="`mmodb-${index}`">
            <strong>{{ $t(index) }}:</strong>
            {{ meta.value }}
          </div>
        </template>
      </div>
    </div>
  </section-layout>
</template>

<script setup lang="ts">
import { PropType, computed, ref, inject } from 'vue'
import { useStore } from '@/store'
import { getImageUrl } from '@/helpers/images'
import { ConditionalFieldGroup } from '@/models/templates'

const $t = inject('$t')
const props = defineProps({
  mainMeta: {
    type: Object as PropType<ConditionalFieldGroup>,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  description: {
    type: String
  },
  linksMeta: {
    type: Object as PropType<ConditionalFieldGroup>,
    default: null
  },
  bottomMeta: {
    type: Object as PropType<ConditionalFieldGroup>,
    default: null
  },
})
const store = useStore();
const showSettings = computed(() => store.state.showSettings)
const showSubSections = computed(() => {
  const showSetting = showSettings.value
  return showSetting.section_2 || showSetting.section_3 || showSetting.section_4;
})

const getImage = computed(() => {
  let file = store.getters.getImagePath

  return getImageUrl(file)
})

function showMeta(field, object) {
  const fieldGroupItem: ConditionalFieldGroup = props[object][field]
  // TODO: Avoid using @ts-ignore for this one..
  if(Object.hasOwn(fieldGroupItem, 'value')) {
    if(Object.hasOwn(fieldGroupItem, 'showIf')) {

      return fieldGroupItem.showIf
    }

    return fieldGroupItem.value
  }

  return false
}
</script>
