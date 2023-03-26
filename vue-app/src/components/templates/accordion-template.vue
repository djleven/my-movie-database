<template>
    <div class="panel-group">
        <template v-for="(section, index) in sections" :key="index">
            <div v-if="section.showIf"
                 class="panel panel-default">
                <div class="panel-heading"
                     @click="setActiveSection(index)"
                     :style="headerStyling">
                    <h3 class="panel-title">
                        <a :class="activeSection === index ? 'activeTab' : ''"
                           :style="`color: ${cssClasses.headerFontColor}`"
                        >
                            {{ section.title }}
                        </a>
                    </h3>
                </div>
                <transition :name="store.state.cssClasses.transitionEffect">
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

defineProps({
  sections: {
    type: Object as PropType<SectionTemplates>,
    required: true
  }
})

const store = useStore();
const cssClasses = computed(() => store.state.cssClasses)
const activeSection = computed(() => store.state.activeSection)
const headerStyling = computed(() => {
  return `background-color: ${cssClasses.value.headerColor}; border-bottom: 1px solid ${cssClasses.value.headerFontColor}`
})

function setActiveSection(newActiveTab) {
  if(newActiveTab === activeSection.value) {
    newActiveTab = -1
  }
  store.commit('setActiveSection', newActiveTab)
}
</script>
