<template>
    <div class="mmdbTabs">
        <ul class="nav nav-tabs" v-if="showTabsNavigation">
            <template v-for="(section, index) in sections" :key="index">
                <li v-if="section.showIf"
                    :class="toggleActiveClass(index)"
                    @click="setActiveSection(index)">
                    <a :class="toggleActiveClass(index)"
                       :style="toggleActiveStyle(index)"
                    >
                      {{ section.title }}
                    </a>
                </li>
            </template>
        </ul>
        <template v-for="(section, index) in sections" :key="index">
            <transition :name="stylingConfig.transitionEffect">
                <template v-if="section.showIf">
                    <div v-show="activeSection === index"
                         class="tab-content">
                        <div class="tab-pane active">
                            <component :is="section.componentName"
                            :section="index">
                            </component>

                        </div>
                    </div>
                </template>
            </transition>
        </template>
    </div>
</template>
<script setup lang="ts">
import { computed, PropType } from 'vue'
import { useStore } from '@/store'
import { SectionTemplates } from '@/models/templates'
import { setStyleColors } from '@/helpers/templating'

const props = defineProps({
  sections: {
    type: Object as PropType<SectionTemplates>,
    required: true
  }
})

const store = useStore();
const activeSection = computed(() => store.state.activeSection);
const stylingConfig = computed(() => store.state.styling);
const showTabsNavigation = computed(() => {
  const sections = props.sections;
  let count = 0
  Object.keys(sections).forEach((key) => {
    if(sections[key].showIf) {
      count++
    }
  })

  return count !== 1
})
function setActiveSection(newActiveTab) {
  if(newActiveTab !== activeSection.value) {
    store.commit('setActiveSection', newActiveTab)
  }
}

function toggleActiveClass(index) {
  return activeSection.value === index ? 'active' : 'inactive'
}

function toggleActiveStyle(index) {
  const isActiveTab = activeSection.value === index
  if(isActiveTab) {
    return setStyleColors(stylingConfig.value.headerColor, stylingConfig.value.headerFontColor)
  }
  return setStyleColors(stylingConfig.value.bodyColor, stylingConfig.value.bodyFontColor)

}
</script>
