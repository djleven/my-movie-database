<template>
    <component v-if="store.state.contentLoaded"
               :is="template"
               :sections="sections">
    </component>
</template>

<script setup lang="ts">
import { computed, onMounted, watch } from 'vue';
import { useStore } from 'vuex';
import {ContentTypes} from "@/models/settings"
import {SectionTemplates} from "@/models/templates"

const store = useStore();
const id = computed(() => store.state.id);
const type = computed(() => store.state.type);
const components = computed(() => store.state.components);
const template = computed(() => store.state.template + '-template');
const showSettings = computed(() => store.state.showSettings);
const translations = computed(() => store.state.__t);
const content = computed(() => store.state.content);

const sections = computed<SectionTemplates>(() => {
  return {
    overview: {
      showIf: true,
      title: translations.value.overview,
      componentName: components.value.overview
    },
    section_2: {
      showIf: showSettings.value.section_2 && Boolean(content.value.credits.cast.length),
      title: translations.value.cast,
      componentName: components.value.section_2
    },
    section_3: {
      showIf: showSettings.value.section_3 && Boolean(content.value.credits.crew.length),
      title: translations.value.crew,
      componentName: components.value.section_3
    },
    section_4: {
      showIf: showSectionFour(),
      title: translations.value.section_4,
      componentName: components.value.section_4
    }
  }
});
function showSectionFour() {
  const conditionOne = showSettings.value.section_4
  if(conditionOne) {
    if (type.value === ContentTypes.Movie) {
      return content?.value?.trailers?.youtube?.length
    } else if (type.value === ContentTypes.TvShow) {
      return content?.value?.seasons?.length
    }
  }

  return false
}
onMounted(() => {
  loadContent()
})

watch(id, () => {
  loadContent()
});

function loadContent() {
  if (id.value && id.value !== 0) {
    store.dispatch('loadContent')
  }
}
</script>