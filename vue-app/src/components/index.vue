<template>
  <component v-if="store.state.contentLoaded"
             :is="template"
             :sections="sections">
  </component>
  <div v-else-if="store.state.error">
    {{store.state.error}}
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { useStore } from '@/store'
import { SectionTemplates } from '@/models/templates'

const store = useStore();
const id = computed(() => store.state.id);
const components = computed(() => store.state.components);
const template = computed(() => store.state.template + '-template');
const showSettings = computed(() => store.state.showSettings);
const translations = computed(() => store.state.__t);

const sections = computed<SectionTemplates>(() => {
  return {
    overview: {
      showIf: true,
      title: translations.value.overview,
      componentName: components.value.overview
    },
    section_2: {
      showIf: showSettings.value.section_2 && store.getters.contentHasCastCredits,
      title: translations.value.cast,
      componentName: components.value.section_2
    },
    section_3: {
      showIf: showSettings.value.section_3 && store.getters.contentHasCrewCredits,
      title: translations.value.crew,
      componentName: components.value.section_3
    },
    section_4: {
      showIf: store.getters.hasSectionFour,
      title: translations.value.section_4,
      componentName: components.value.section_4
    }
  }
});

onMounted(() => {
  loadContent()
})

watch(id, () => {
  loadContent()
});

function loadContent() {
  if (id.value && Number(id.value) !== 0) {
    store.dispatch('loadContent')
  }
}
</script>