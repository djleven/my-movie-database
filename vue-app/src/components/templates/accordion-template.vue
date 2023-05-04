<template>
    <div class="panel-group mmdb-accordion">
        <template v-for="(section, index) in sections" :key="index">
            <div v-if="section.showIf"
                 class="panel panel-default">
                <div v-if="showAccordionNavigation"
                     class="panel-heading"
                     @click="setActiveSection(index)"
                     :style="headerStyling">
                    <h3 class="panel-title">
                        <a :class="activeSection === index ? 'activeTab' : ''"
                           :style="`color: ${styling.headerFontColor}`"
                        >
                            {{ section.title }}
                        </a>
                    </h3>
                </div>
                <transition :name="store.state.styling.transitionEffect">
                    <div class="panel-body mmdb-body"
                         v-show="activeSection === index">
                        <component :is="section.componentName"
                                   :section="index">
                        </component>
                    </div>
                </transition>
            </div>
        </template>
    </div>
</template>

<script setup lang="ts">
import { computed, PropType } from 'vue'
import { useStore } from '@/store'
import { SectionTemplates } from '@/models/templates'
import {Color} from "@/models/settings";

const props = defineProps({
  sections: {
    type: Object as PropType<SectionTemplates>,
    required: true
  }
})

const store = useStore();
const styling = computed(() => store.state.styling)
const activeSection = computed(() => store.state.activeSection)
const headerStyling = computed(() => {
  return `background-color: ${styling.value.headerColor}; border-bottom: 3px solid ${styling.value.bodyColor}`
})

function setActiveSection(newActiveTab) {
  if(newActiveTab === activeSection.value) {
    newActiveTab = -1
  }
  store.commit('setActiveSection', newActiveTab)
}
const showAccordionNavigation = computed(() => {
  const sections = props.sections;
  let count = 0
  Object.keys(sections).forEach((key) => {
    if(sections[key].showIf) {
      count++
    }
  })

  return count !== 1
})
</script>
