<template>
    <div class="mmdb-body mmdb-search white">
        <div>
            <div class="loader" v-if="loading">
                <div class="loaderInner">
                </div>
            </div>
            <input type="text"
                   v-model="searchInput"
                   @input="search"/>
        </div>
        <div class="panel-body">
            <div v-for="(result, index) in results"
                 :key="index"
                 class="col-xl-4 col-lg-6 col-md-6 col-sm-6 credits mmdb-search">
                <div :class="active === index ? 'info bg-image' : 'info'"
                     :style="bgImage(index)"
                     @click="active=index"
                     @mouseover="active=index">
                    <div class="title-container">
                        <h3>{{ getTitle(index) }}</h3>
                    </div>
                    <div class="description">
                        <template v-if="active === index">
                            <p class="bold center-text">TMDb ID: {{ result.id }}</p>
                            <div v-if="getDescription(index)">{{ getDescription(index) }}</div>
                            <p v-else class="center-text">{{ $store.state.__t.no_description }}</p>
                        </template>
                    </div>
                    <div v-if="active === index"
                         class="button-primary"
                         @click="select(index)">
                         Select
                    </div>
                    <img :src="getImage(index)" v-else/>
                </div>
            </div>
            <div v-if="!results.length && searched">
                <h4>No search results found</h4>
            </div>
        </div>
        <index v-show="!results.length"
               @content-success="contentLoadSuccess"
               @content-finally="contentLoadFinally">
        </index>
    </div>

</template>
<style scoped>
    .mmdb-body.mmdb-search.white {
        background: #fff;
        padding: 0 10px;
    }
    .mmdb-body.mmdb-search {
        text-align: center;
    }
    .mmdb-body.mmdb-search .info img, .mmdb-search .info .description {
        max-height: 272px;
        max-width: 196px;
        object-fit: cover;
        text-align: left;
        margin: auto;
    }
    .mmdb-body.mmdb-search .info .description {
        font-size: 12px;
        line-height: 16px;
        overflow: auto;
    }
    .mmdb-body.mmdb-search .info .title-container  {
        height: 75px;
        line-height: 75px;
        padding: 0 4px;
    }
    .mmdb-body.mmdb-search .info .title-container h3 {
        color: #000;
        display: inline-block;
        vertical-align: middle;
        line-height: normal;
    }

    .mmdb-body.mmdb-search .info {
        height: 367px;
        padding: 10px 5px;
        cursor: pointer;
    }
    .mmdb-body.mmdb-search .bold {
        font-weight: bold;
    }
    .mmdb-body.mmdb-search .credits.mmdb-search {
        padding: 20px 15px;
        border-radius: 20px;
    }
    .mmdb-search .loader {
        background: rgba(0,0,0,0.5);
        bottom: 0;
        height: 100%;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        width: 100%;
        z-index: 999;
    }
    .mmdb-search .loaderInner {
        height: 60px;
        left: 50%;
        margin: -50px 0 0 -50px;
        position: absolute;
        top: 50%;
        width: 60px;
    }
    .mmdb-search .button-primary {
        position: absolute;
        bottom: 40px;
        left: 0;
        right: 0;
        width: 120px;
        margin: auto;
    }
</style>
<script>
    module.exports = {
        data: function () {
            return {
                searchInput: '',
                page: 1,
                results: [],
                total_pages: null,
                active: null,
                searched: false,
                loading: false
            }
        },
        methods: {
            search: function () {
                let _this = this
                const type = this.$store.state.type
                let query = theMovieDb.search[type]({query: this.searchInput})
                query.then( function (data) {
                    _this.page = data.page
                    _this.results = data.results
                    _this.total_pages = data.total_pages
                    _this.searched = true
                })
            },
            getTitle: function (index) {
                const title = this.results[index].name || this.results[index].title

                return theMovieDb.helpers.getTitleWithYear(title, this.releaseDate(index))
            },
            getImage: function (index) {
                const size = 'medium'
                let file =
                    this.results[index].poster_path || this.results[index].profile_path
                if(file) {
                    return theMovieDb.helpers.getImage(file, size)
                }

                return this.$store.state.placeholder[size]
            },
            getExcerpt: function (index) {
                let text = this.results[index].overview
                if(text) {

                    return theMovieDb.helpers.getExcerpt(text, 350)
                }
                return null
            },
            getDescription: function (index) {
                return this.getExcerpt(index) || this.knownFor(index)
            },
            knownFor: function (index) {
                let known_for = this.results[index].known_for
                if(known_for && known_for.length) {
                    return known_for.map(function(elem){
                        return elem.name || elem.title;
                    }).join(", ");
                }
                return null
            },
            releaseDate: function (index) {

                return this.results[index].release_date || this.results[index].first_air_date
            },
            bgImage: function (index) {
                if(this.active === index) {
                    return `background-image: url('${this.getImage(index)}')`
                }
                return ''
            },
            contentLoadSuccess: function () {
                this.results = []
                this.searchInput = ''
                this.searched = false
            },
            contentLoadFinally: function () {
                this.loading = false
            },
            select: function (index) {
                const id = this.results[index].id
                this.loading = true
                document.getElementById('MovieDatabaseID').value = id;
                this.$store.commit('setID', id)
                this.$store.commit('setActive', 'overview')
            }
        }
    }
</script>