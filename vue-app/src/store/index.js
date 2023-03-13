import Movie from '../models/movie.js'
import Tvshow from '../models/tvshow.js'
import Person from '../models/person.js'

const mutations = {
    addContent(state, payload) {
        state.content = payload
    },
    addCredits(state, payload) {
        state.credits = payload
    },
    setActive(state, activeTab) {
        state.activeTab = activeTab
    },
    setID(state, id) {
        state.id = id
    },
}

const actions = {
    loadContent({ commit, state }, products) {
        // let id = this.id
        // if (id && id !== 0) {
        //     let credits
        //     let content = this.getById(id)
        //     content.then((data) => {
        //         data = JSON.parse(data)
        //         if (this.$store.state.global_conf.debug) {
        //             console.log(data)
        //         }
        //         if(data.hasOwnProperty('credits')) {
        //             credits = data.credits
        //         } else if(data.hasOwnProperty('combined_credits')) {
        //             credits = data.combined_credits
        //         } else {
        //             console.log('Error: No credits found in response')
        //         }
        //
        //         this.crewLength = credits.crew.length
        //         this.castLength = credits.cast.length
        //
        //         commit('addContent', data)
        //         commit(
        //           'addCredits',
        //           this.processCreditsPayload(credits)
        //         )
        //
        //         this.$emit('content-success')
        //         console.log(this.$store.state)
        //     })
        //     content.catch(() => {
        //
        //     })
        //     content.finally(() => {
        //         this.$emit('content-finally')
        //     })
        // }
    }
}


const initiateStore = (conf, i18n) => {
    const type = conf.type
    let object
    if(type === 'movie') {
       object = new Movie()
    }else if(type === 'tvshow') {
        object =  new Tvshow()
    }else if(type === 'person') {
        object =  new Person()
    }

    const myState = Object.assign({
        content: null,
        credits: null,
        components: object.components,
        activeTab: "overview",
        __t: i18n
    }, conf)

    return {
        state: myState,
        actions,
        mutations
    }
}

export default initiateStore