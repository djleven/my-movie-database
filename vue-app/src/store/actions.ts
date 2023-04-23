import { getById, searchAPI } from '@/helpers/resourceAPI'
import { ContentTypes } from '@/models/settings'
import { PersonCredits, ScreenPlayCredits } from '@/models/credits'
import { MovieData } from '@/store/movie'
import { PersonData } from '@/store/person'
import { TvShowData } from '@/store/tv'
import { validateMoviesSearchResponse } from '@/models/apiTypes/search/MoviesSearchResponse.validator'
import { validateTvShowsSearchResponse } from '@/models/apiTypes/search/TvShowsSearchResponse.validator'
import { validatePeopleSearchResponse } from '@/models/apiTypes/search/PeopleSearchResponse.validator'
import PeopleSearchResponse from '@/models/apiTypes/search/PeopleSearchResponse'
import TvShowsSearchResponse from '@/models/apiTypes/search/TvShowsSearchResponse'
import MoviesSearchResponse from '@/models/apiTypes/search/MoviesSearchResponse'

export default {
    async loadContent({ commit, state, dispatch }) {
        const id = state.id
        const type = state.type
        const errorMsg = `Error fetching ${type} results`

        commit('setContentLoading', true)
        commit('setContentLoaded', false)

        try {
            let data
            const response = await getById({id, type})
            if(!response.parsedBody) {
                throw Error(errorMsg)
            }

            data = JSON.parse(response.parsedBody)
            if (state.global_conf.debug) {
                console.log(data, 'Content type response data')
            }

            return dispatch('addContent', data)
        }
        catch(e) {
            console.error(e, errorMsg)
            commit('setErrorMessage', errorMsg)
        }
        finally {
            commit('setContentLoading', false)
        }
    },
    addContent({state, commit, dispatch}, data: MovieData | PersonData | TvShowData) {
        const type = state.type
        try {
            let credits: ScreenPlayCredits | PersonCredits | null = null

            if(type === ContentTypes.Person && 'combined_credits' in data) {
                credits = data.combined_credits
            } else if('credits' in data) {
                credits = data.credits
            } else {
                console.error('Error: No credits found in response')
                throw Error('Error: No credits found in response')
            }

            if(credits) {
                commit(`${type}/setCredits`, credits)
            }
            commit(`${type}/setContent`, data)
            dispatch(`${type}/setContentLoaded`)
        }
        catch(e){
            const msg = `An error occurred while loading the ${type} data`
            console.error(msg)
            commit('setErrorMessage', msg)
        }
        finally {
            commit('setContentLoading', false)
        }
    },

    setContentLoaded(state, status: boolean) {
        state.contentLoaded = status
    },
    async searchForResources({ commit, state }, val):
        Promise<PeopleSearchResponse | TvShowsSearchResponse | MoviesSearchResponse>
    {
        let data
        const errorMsg = `Error fetching search results for ${val}`
        try {
            const type = state.type
            let query = await searchAPI(val, type)

            if(!query.parsedBody) {
                throw Error(errorMsg)
            }
            data = JSON.parse(query.parsedBody)

            if(type === ContentTypes.Movie) {
                data = validateMoviesSearchResponse(data)
            }
            else if(type === ContentTypes.TvShow) {
                data = validateTvShowsSearchResponse(data)
            }
            else if (type === ContentTypes.Person) {
                data = validatePeopleSearchResponse(data)
            }
        }
        catch(e){
            console.error(e, errorMsg)
            commit('setErrorMessage', errorMsg)
        }

        return data
    }
}
