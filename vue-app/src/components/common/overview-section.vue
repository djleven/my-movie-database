<template>
  <section-layout
      :show-header="showSubSections"
      :header="store.state.__t.summary"
      class-list="overview"
  >
    <div>
      <h1 class="entry-title">
        {{ title }}
      </h1>
      <div :class="store.state.cssClasses.twoColumn">
        <img class="mmdb-poster"
             :src="getImage()"
             ref="poster"
             :alt="`${title} image`"
        />
      </div>
      <div :class="`meta-wrapper ${store.state.cssClasses.twoColumn}`" :style="`height: ${metaWrapperHeight}`">
        <div class="mmdb-meta">
          <template v-for="(meta, index) in mainMeta" :key="index">
            <div v-if="showMeta(index, 'mainMeta')" :class="`mmodb-${index}`">
              <strong>{{ store.state.__t[index] }}:</strong>
              {{ meta.value }}
            </div>
          </template>

          <template v-for="(meta, index) in linksMeta" :key="index">
            <div v-if="showMeta(index, 'linksMeta')" :class="`mmodb-${index}`">
              <a target="_blank" :href="meta.value">
                <strong>{{ store.state.__t[index] }}</strong>
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
            <strong>{{ store.state.__t[index] }}:</strong>
            {{ meta.value }}
          </div>
        </template>
      </div>
    </div>
  </section-layout>
</template>

<script setup lang="ts">
import {defineProps, PropType, computed, ref} from "vue"
import {useStore} from "vuex"

import {getImageUrl} from '@/helpers/templating';
import {ConditionalFieldGroup} from "@/models/templates";

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
const poster = ref<HTMLImageElement | null>(null)

const showSettings = computed(() => store.state.showSettings)
const showSubSections = computed(() => {
  const showSetting = showSettings.value
  return showSetting.section_2 || showSetting.section_3 || showSetting.section_4;
})

const metaWrapperHeight = computed(() => {
  const imageHeight = poster.value?.offsetHeight;

  return imageHeight ?  imageHeight + 'px' : 'unset'
})

function showMeta(field, object) {
  const fieldGroupItem: ConditionalFieldGroup = props[object][field]
  if(Object.hasOwn(fieldGroupItem, 'value')) {
    if(Object.hasOwn(fieldGroupItem, 'showIf')) {

      return fieldGroupItem.showIf
    }

    return fieldGroupItem.value
  }

  return false
}

function getImage() {
  let size = 'large'
  let file =
      store.state.content?.poster_path || store.state.content?.profile_path

  if (file) {
    return getImageUrl(file, size)
  }

  return store.state.placeholder?.value?.[size]
}

</script>
