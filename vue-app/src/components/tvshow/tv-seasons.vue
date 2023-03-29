<template>
    <section-layout :header="$t('seasons')"
              :sub-header="store.state.tvshow?.content?.name"
              class-list="seasons">
        <credit-list :overview-on-hover="store.state.global_conf.overviewOnHover"
                 image-size="medium"
                 column-class="twoColumn"
                 :credits="store.state.tvshow?.content?.seasons">
        </credit-list>
    </section-layout>
</template>
<script setup lang="ts">
import { inject } from 'vue'
import { useStore } from '@/store'

const $t = inject('$t')
const store = useStore();
</script>
