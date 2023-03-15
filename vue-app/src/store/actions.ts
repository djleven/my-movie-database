import {getById} from "@/helpers/resourceAPI.js";

const processCreditsPayload = (data, type) => {
    if(type === 'person') {
        data = {
            cast: {
                movie: orderCredits(
                    filterCreditsByMediaType(data.cast, 'movie'),
                    'release_date',
                    true
                ),
                tv: orderCredits(
                    filterCreditsByMediaType(data.cast, 'tv'),
                    'episode_count'
                )
            },
            crew: {
                movie: orderCredits(
                    filterCreditsByMediaType(data.crew, 'movie'),
                    'release_date',
                    true
                ),
                tv: orderCredits(
                    filterCreditsByMediaType(data.crew, 'tv'),
                    'episode_count'
                )
            }
        }
    } else {
        data.cast = orderCredits(data.cast, 'order', false, false)
    }
    return data
}

const orderCredits = (credits, comparison, date = false, desc = true) => {
    if(Array.isArray(credits) && credits.length) {
        if(date) {
            const unixReleaseDate = 'unixReleaseDate'
            credits.map((credit) => {
                credit[unixReleaseDate] = + new Date(credit[comparison])
            })
            comparison = unixReleaseDate
        }
        return credits.sort((a, b) => {
            if(desc) {
                return b[comparison] - a[comparison];
            } else {
                return a[comparison] - b[comparison];
            }
        });
    }

    return credits
}

const filterCreditsByMediaType = (credits, filter) => {
    return credits.filter((credit) => {
        if(credit.media_type  === filter) {
            return credit
        }
    });
}


export default {
    loadContent({ commit, state }) {
        const id = state.id
        const type = state.type
        if (id && id !== 0) {
            commit('setContentLoading', true)
            commit('setContentLoaded', false)
            let credits
            let content = getById({id, type})
            content.then((response) => {
                const data = JSON.parse(response)
                if (state.global_conf.debug) {
                    console.log(data, 'parsed response')
                }
                if(data.hasOwnProperty('credits')) {
                    credits = data.credits
                } else if(data.hasOwnProperty('combined_credits')) {
                    credits = data.combined_credits
                } else {
                    console.log('Error: No credits found in response')
                }

                commit('addContent', data)
                commit(
                    'addCredits',
                    processCreditsPayload(credits, type)
                )

                // this.$emit('content-success')
                commit('setContentLoaded', true)


                console.log(state)
            })
            content.catch(() => {

            })
            content.finally(() => {
                // this.$emit('content-finally')
                commit('setContentLoading', false)
            })
        }
    }
}
