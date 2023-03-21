<template>
    <section-layout :header="store.state.__t.seasons"
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
import { useStore } from '@/store'
const store = useStore();
</script>
