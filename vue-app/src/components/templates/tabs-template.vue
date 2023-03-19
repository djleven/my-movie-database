<template>
    <div class="mmdbTabs">
        <ul class="nav nav-tabs">
            <template v-for="(section, index) in sections" :key="index">
                <li :class="activeSection === index ? 'active' : ''"
                    v-if="section.showIf"
                    @click="setActiveSection(index)">
                    <a :class="activeSection === index ? 'active activeTab' : ''">
                        {{ section.title }}
                    </a>
                </li>
            </template>
        </ul>
        <template v-for="(section, index) in sections" :key="index">
            <transition :name="$store.state.cssClasses.transitionEffect">
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
import {defineProps, computed} from "vue"
import {useStore} from "vuex"
import {SectionTemplates} from "@/models/templates"

defineProps({
  sections: {
    type: SectionTemplates,
    required: true
  }
})

const store = useStore();
const activeSection = computed(() => store.state.activeSection);

function setActiveSection(newActiveTab) {
  if(newActiveTab === activeSection.value) {
    newActiveTab = -1
  }
  store.commit('setActiveSection', newActiveTab)
}
</script>
