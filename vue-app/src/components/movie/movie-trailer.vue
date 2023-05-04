<template>
    <section-layout :header="$t('trailer')"
              :sub-header="store.state.movie?.content?.title"
              class-list="trailer">
        <div class="mmdb-trailer-video">
            <iframe width="560" height="315" frameborder="0"
                    :src="videoSource"
                    allowfullscreen>
            </iframe>
        </div>
    </section-layout>
</template>

<script setup lang="ts">
import { inject } from 'vue'
import { useStore } from '@/store'

const $t = inject('$t')
const store = useStore();

const youtubeUrl = 'https://www.youtube-nocookie.com/embed/'
const videoSource = `${youtubeUrl}${store.state.movie?.content?.trailers?.youtube[0]?.source}`
</script>
