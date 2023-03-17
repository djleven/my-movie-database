import {getById} from "@/helpers/resourceAPI";
import {ContentTypes} from "@/models/settings";

export default {
    async loadContent({ commit, state }) {
        const id = state.id
        const type = state.type

        commit('setContentLoading', true)
        commit('setContentLoaded', false)

        try {
            const response = await getById({id, type})
            const data = JSON.parse(response.parsedBody)
            if (state.global_conf.debug) {
                console.log(data, 'response data')
            }

            if(type === ContentTypes.Person && data.combined_credits) {
                commit('addExtendedCredits', data.combined_credits)
            } else if(data.credits) {
                commit('addBaseCredits', data.credits)
            } else {
                console.log('Error: No credits found in response')
            }

            commit('addContent', data)
            commit('setContentLoaded', true)
        }
        catch(e){
            // TODO: better error handling and front-end notification
            console.log(e,'An error has occurred')
        }
        finally {
            commit('setContentLoading', false)
        }
    }

}
