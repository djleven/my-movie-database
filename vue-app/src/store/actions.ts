import { getById } from "@/helpers/resourceAPI";
import { ContentTypes } from "@/models/settings";
import {PersonCredits, ScreenPlayCredits} from "@/models/credits";

export default {
    async loadContent({ commit, state, dispatch }) {
        const id = state.id
        const type = state.type

        commit('setContentLoading', true)
        commit('setContentLoaded', false)

        try {
            const response = await getById({id, type})
            const data = JSON.parse(response.parsedBody)
            if (state.global_conf.debug) {
                console.log(data, 'Content type response data')
            }

            dispatch('addContent', data)
        }
        catch(e){
            // TODO: better error handling and front-end notification
            const msg = 'An error has occurred'
            console.log(e,msg)
            commit('setError', msg)
        }
        finally {
            commit('setContentLoading', false)
        }
    },
    addContent({state, commit, dispatch}, data: any) {
        try {
            const type = state.type
            let credits: ScreenPlayCredits | PersonCredits | null = null

            if(type === ContentTypes.Person && data.combined_credits) {
                credits = data.combined_credits
            } else if(data.credits) {
                credits = data.credits
            } else {
                console.log('Error: No credits found in response')
                commit('setError', 'Error: No credits found in response')
            }

            if(credits) {
                commit(`${type}/setCredits`, credits)
            }
            commit(`${type}/setContent`, data)
            dispatch(`${type}/setContentLoaded`)
        }
        catch(e){
            // TODO: better error handling and front-end notification
            const msg = 'An error has occurred'
            console.log(e,msg)
            commit('setError', msg)
        }
        finally {
            commit('setContentLoading', false)
        }
    },

    setContentLoaded(state, status: boolean) {
        state.contentLoaded = status
    },

}
