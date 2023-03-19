<template>
    <section-layout :header="getHeader"
              :sub-header="store.state.content.name || store.state.content.title"
              :class-list="templateType">
      <slot>
        <extended-credits
            v-if="store.state.type === ContentTypes.Person"
            :credits="credits"
            :i18-title-key-suffix="templateType"
            :overview-on-hover="store.state.global_conf.overviewOnHover"
        />
        <credit-list
            v-else
            :credits="credits"
            :overview-on-hover="false"
        />
      </slot>

    </section-layout>
</template>

<script setup lang="ts">

import {defineProps, computed} from "vue"
import {useStore} from "vuex"
import {BaseTemplateSections, ContentTypes} from "@/models/settings"

const props = defineProps({
  section: {
    type: String,
    required: true,
  },
})

const sectionTypeMap = {
  [BaseTemplateSections.Section_2]: 'cast',
  [BaseTemplateSections.Section_3]: 'crew',
}

const store = useStore()
const templateType: string = sectionTypeMap[props.section]
const credits = computed(() => store.state.credits[templateType])
const getHeader = computed(() => store.state.__t[templateType])

</script>
