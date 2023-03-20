<template>
    <div>
        <h4 v-if="i18TitleKey"
            @click="activeCredit=null"
            @mouseover="activeCredit=null" >{{ store.state.__t[i18TitleKey] }}</h4>
        <div :class="overviewOnHover ? 'overview-on-hover' : 'credits-wrapper'">
            <template v-for="(credit, index) in credits" :key="index">
               <credit-item
                   :credit="credit"
                   :index="index"
                   :is-active="overviewOnHover && index === activeCredit"
                   :column-class="columnClass"
                   :image-size="imageSize"
                   :has-set-active-events="overviewOnHover"
                   @set-active="setActiveCredit"
               />
            </template>
        </div>
        <div style="clear:both"></div>
    </div>
</template>

<script setup lang="ts">
import {defineProps, ref} from "vue"
import {useStore} from "vuex"

const props = defineProps({
  credits: {
    type: Array,
    required: true
  },
  columnClass: {
    type: String,
    default: 'multipleColumn'
  },
  i18TitleKey: {
    type: String,
    default: null
  },
  imageSize: {
    type: String,
    default: 'small'
  },
  overviewOnHover: {
    type: Boolean,
    default: false
  }
})

const store = useStore()
const activeCredit = ref(null);

function setActiveCredit(index) {
  activeCredit.value = index
}
</script>
