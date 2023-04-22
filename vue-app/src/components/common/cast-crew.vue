<template>
    <section-layout :header="$t(headerLabel())"
              :sub-header="store.getters.getContentTitle"
              :class-list="headerClassList">
      <slot>
        <extended-credits
            v-if="isPersonType"
            :credits="credits"
            :image-size="store.state.styling.size"
            :i18-title-key-suffix="templateType"
            :overview-on-hover="store.state.global_conf.overviewOnHover"
        />
        <credit-list
            v-else
            :image-size="store.state.styling.size"
            :credits="credits"
            :overview-on-hover="false"
        />
      </slot>
    </section-layout>
</template>

<script setup lang="ts">
import { computed, inject } from 'vue'
import { useStore } from '@/store'
import { BaseTemplateSections, ContentTypes } from '@/models/settings'

const $t = inject('$t')
const $tc = inject('$tc')
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
const contentType = computed(() => store.state.type)
const isPersonType:boolean = contentType.value === ContentTypes.Person
const templateType: string = sectionTypeMap[props.section]
const headerClassList: string = `${contentType.value} credits ${templateType}`
const credits = computed(() => store.state[contentType.value]?.credits[templateType])
const headerLabel = ():string => isPersonType ? `${ContentTypes.Person}.${templateType}` : templateType
</script>
