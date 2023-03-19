<template>
    <section-layout :show-header="showSubSections()"
              :header="$store.state.__t.summary"
              class-list="overview">
        <div>
            <h1 class="entry-title">
                {{ title }}
            </h1>
            <div :class="$store.state.cssClasses.twoColumn">
                <img class="mmdb-poster"
                     :src="getImage()"
                     ref="poster"
                     :alt="title + ' image'"
                />
            </div>
            <div :class="'meta-wrapper ' + $store.state.cssClasses.twoColumn"
                 ref="metaWrapper">
                <div class="mmdb-meta">
                    <template v-for="(meta, index) in mainMeta">
                        <div v-if="showMeta(index, 'mainMeta')">
                            <strong>{{ $store.state.__t[index] }}:</strong>
                            {{ meta.value }}
                        </div>
                    </template>

                    <template v-for="(meta, index) in linksMeta">
                        <div v-if="showMeta(index, 'linksMeta')">
                            <a target="_blank" :href="meta.value">
                                <strong>{{ $store.state.__t[index]  }}</strong>
                            </a>
                        </div>
                    </template>
                </div>
            </div>
            <div class="clearfix"></div>
            <div v-if="$store.state.showSettings.overview_text"
                 class="col-md-12 overview-text">
                {{ description }}
            </div>
            <div class="col-md-12">
                <template v-for="(meta, index) in bottomMeta">
                    <div v-if="showMeta(index, 'bottomMeta')">
                        <strong>{{ $store.state.__t[index] }}:</strong>
                        {{ meta.value }}
                    </div>
                </template>
            </div>
        </div>
    </section-layout>
</template>

<script>
import {getImageUrl} from '@/helpers/templating';
    export default {
        props: {
            mainMeta: {
                type: Object,
                required: true
            },
            title: {
                type: String,
                required: true
            },
            description: {
                type: String
            },
            linksMeta: {
                type: Object
            },
            bottomMeta: {
                type: Object
            },
        },
        mounted(){
            this.setMetaWrapperHeight()
        },
        methods: {
            showMeta(field, object) {
                if(Object.hasOwn(this[object][field], 'value')) {
                    if(Object.hasOwn(this[object][field], 'showIf')) {

                        return this[object][field].showIf
                    }

                    return this[object][field].value
                }

                return false
            },
            showSubSections() {
                const show = this.$store.state.showSettings
                return show.section_2 || show.section_3 || show.section_4;
            },
            getImage() {
                let size = 'large'
                let file =
                    this.$store.state.content.poster_path || this.$store.state.content.profile_path

                if (file) {
                    return getImageUrl(file, size)
                }

                return this.$store.state.placeholder[size]
            },
            setMetaWrapperHeight() {
                const _this = this
                setTimeout(function(){
                    let imageHeight = _this.$refs.poster.offsetHeight
                    if(imageHeight > 50) {
                        _this.$refs.metaWrapper.style.height = imageHeight + 'px'
                    } else {
                        _this.setMetaWrapperHeight()
                    }
                }, 400)
            }
        }

    }
</script>
