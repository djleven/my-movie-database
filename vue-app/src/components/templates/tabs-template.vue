<template>
    <div class="mmdbTabs">
        <ul class="nav nav-tabs">
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
                         class="tab-content mmdb-header">
                        <div class="tab-pane active">
                            <component :is="section.componentName"
                            :section="index">
                            </component>

                        </div>
                    </div>
                </template>
            </transition>
        </template>
        <div class="clearfix"></div>
    </div>
</template>
<script setup lang="ts">
import { computed, PropType } from 'vue'
import { useStore } from '@/store'
import { SectionTemplates } from '@/models/templates'
import { setStyleColors } from '@/helpers/templating'

defineProps({
  sections: {
    type: Object as PropType<SectionTemplates>,
    required: true
  }
})

const store = useStore();
const activeSection = computed(() => store.state.activeSection);
const stylingConfig = computed(() => store.state.cssClasses);

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
