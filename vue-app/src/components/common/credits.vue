<template>
    <div>
        <h4 v-if="title"
            @click="active=null"
            @mouseover="active=null" >{{ $store.state.__t[title] }}</h4>
        <div :class="overviewOnHover ? 'overview-on-hover' : 'credits-wrapper'">
            <template v-for="(credit, index) in credits">
                <div :class="$store.state.cssClasses[columnClass] + ' credits'"
                     ref="creditWrapper"
                     @click="activeState(index)"
                     @mouseover="activeState(index)">
                    <div class="img-container">
                        <div v-if="overviewOnHover && active === index"
                             class="description">
                            <template v-if="credit.overview">
                                {{ getExcerpt(credit.overview, excerptLength) }}
                            </template>
                            <p v-else class="center-text">
                                {{ $store.state.__t.no_description }}
                            </p>

                        </div>
                        <img v-else
                             :class="imageSize === 'small' ? 'img-circle' : 'image'"
                             :alt="credit.title || credit.name + ' image'"
                             :src="getImage(index)"/>
                    </div>
                    <ul class="credits">
                        <li>{{ credit.title || credit.name }}</li>
                        <li v-if="credit.character">
                            {{ $store.state.__t.role }}: {{ credit.character }}
                        </li>
                        <li v-if="credit.job">{{ credit.job }}
                        </li>
                        <li v-if="credit.air_date">
                            {{ $store.state.__t.air_date }}: {{ formatDate(credit.air_date) }}
                        </li>
                        <li v-if="credit.episode_count">
                            {{ $store.state.__t.episode_count }}: {{ credit.episode_count }}
                        </li>
                    </ul>
                </div>
            </template>
        </div>
        <div style="clear:both"></div>
    </div>
</template>

<script>
    import helpers from '../../mixins/helpers.js';

    export default {
        mixins: [helpers],
        props: {
            credits: {
                type: Array,
                required: true
            },
            columnClass: {
                type: String,
                default: 'multipleColumn'
            },
            title: {
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
        },
        data() {
            return {
                active: null,
                excerptLength: 350
            }
        },
        watch: {
            active() {
                const active = this.active
                const el = this.$refs.creditWrapper
                const _this = this
                Object.keys(this.credits).forEach(function (a, index) {
                    if(index === active) {
                        el[index].style.backgroundImage='url("' + _this.getImage(index) + '")'
                        el[index].classList.add('bg-image')
                    } else {
                        el[index].style.backgroundImage='none'
                        el[index].classList.remove('bg-image')
                    }
                })
            }
        },
        methods: {
            getImage(index) {
                let size = this.imageSize
                let file =
                    this.credits[index].poster_path || this.credits[index].profile_path

                if(file) {
                    return this.getImageUrl(file, size)
                }

                return this.$store.state.placeholder[size]
            },
            activeState(index) {
                if(this.overviewOnHover && index !== this.active) {
                    this.active = index
                }
            }
        },
    }
</script>
