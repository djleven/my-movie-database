<template>
  <section-layout
      :show-header="showSubSections"
      :header="$t('summary')"
      class-list="overview"
  >
    <div class="mmdb-flex-container">
      <h1 class="entry-title col-all-12">
        {{ title }}
      </h1>
      <div :class="store.state.cssClasses.twoColumn">
        <img class="mmdb-poster"
             :src="getImage"
             :alt="`${title} image`"
        />
      </div>
      <div :class="`meta-wrapper ${store.state.cssClasses.twoColumn}`">
        <div class="mmdb-meta">
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
      </div>
      <div class="clearfix"></div>
      <div v-if="store.state.showSettings.overview_text"
           class="col-md-12 overview-text">
        {{ description }}
      </div>
      <div class="col-md-12">
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

import { getImageUrl, placeholderImages } from '@/helpers/templating'
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
  let size = 'large'
  let file = store.getters.getImagePath

  if (file) {
    return getImageUrl(file, size)
  }

  return ref(require(`../../assets/img/${placeholderImages[size]}`)).value
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
