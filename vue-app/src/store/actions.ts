import { getById, searchAPI } from '@/helpers/resourceAPI'
import { ContentTypes } from '@/models/settings'
import { PersonCredits, ScreenPlayCredits } from '@/models/credits'
import { MovieData } from '@/store/movie'
import { PersonData } from '@/store/person'
import { TvShowData } from '@/store/tv'
import { validateMoviesSearchResponse } from '@/models/searchTypes/movie.validator'
import { validateTvShowsSearchResponse } from '@/models/searchTypes/tvshow.validator'
import { validatePeopleSearchResponse } from '@/models/searchTypes/person.validator'
import PeopleSearchResponse from '@/models/searchTypes/person'
import TvShowsSearchResponse from '@/models/searchTypes/tvshow'
import MoviesSearchResponse from '@/models/searchTypes/movie'

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
