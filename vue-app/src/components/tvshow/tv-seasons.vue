<template>
    <section-layout :header="$t('seasons')"
              :sub-header="store.state.tvshow?.content?.name"
              class-list="seasons">
        <credit-list :overview-on-hover="store.state.global_conf.overviewOnHover"
                 :image-size="store.state.styling.size"
                 :column-class="ImageType.Rectangular"
                 :credits="store.state.tvshow?.content?.seasons">
        </credit-list>
    </section-layout>
</template>
<script setup lang="ts">
import { inject } from 'vue'
import { useStore } from '@/store'
import { ImageType } from '@/helpers/images'

const $t = inject('$t')
const store = useStore();
</script>
