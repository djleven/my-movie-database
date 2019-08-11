<template>
    <sections :header="$store.state.__t.trailer"
              :sub-header="$store.state.content.title"
              class-list="trailer">
        <div class="mmdb-trailer-video">
            <iframe width="560" height="315" frameborder="0"
                    :src="'https://www.youtube-nocookie.com/embed/' + $store.state.content.trailers.youtube[0].source"
                    allowfullscreen>
            </iframe>
        </div>
    </sections>

</template>
<style scoped>
    .mmdb-trailer-video {
        position: relative;
        padding-bottom: 56.25%;
        padding-top: 25px;
        height: 0;
        max-width: 1920px;
        margin: 0 auto;
    }
    .mmdb-trailer-video iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        max-height: 1080px;
    }
</style>