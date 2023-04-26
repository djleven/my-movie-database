import { ScreenPlayCredits } from '@/models/credits'
import MovieData from '@/models/apiTypes/MovieData'
import { orderCredits } from '@/helpers/templating'
import {BaseTemplateSections} from '@/models/settings'
import {EntityComponents, AppComponents} from '@/models/templates'

export interface MovieState {
    content: MovieData | null
    credits: ScreenPlayCredits
    components: EntityComponents
}

const TypeComponents: EntityComponents = {
    [BaseTemplateSections.Overview]: AppComponents.MovieOverview,
    [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_4]: AppComponents.MovieTrailer,
}

const content: Partial<MovieData> | null = null

const credits: ScreenPlayCredits = {
    cast: [],
    crew: []
}
export default {
    namespaced: true,
    state: (): MovieState => ({
        content,
        credits,
        components: TypeComponents
    }),
    mutations: {
        setCredits(state, {cast, crew}: ScreenPlayCredits) {
            state.credits = Object.assign({}, {
                cast: orderCredits(cast, 'order', false, false),
                crew: orderCredits(crew, 'popularity', false, true)
            })
        },
        setContent(state, data: MovieData) {
            state.content = Object.assign({}, data)
        },
    },
    getters: {
        contentHasCastCredits: (state) => {
            return Boolean(state.content?.credits?.cast?.length)
        },
        contentHasCrewCredits: (state) => {
            return Boolean(state.content?.credits?.crew?.length)
        },
        hasSectionFour: (state) => {
            return state.content?.trailers?.youtube?.length
        },
        sectionFourLabelKey: () => 'trailer',
        getContentTitle: (state) => {
            return state.content?.title
        },
        getImagePath: (state)  => {
            return state.content?.poster_path
        }
    },
    actions: {
        setContentLoaded({state, commit}) {
            if(state.content !== null) {
                return commit('setContentLoaded', true, { root: true });
            }
            commit('setErrorMessage', 'Failed to load Movie data', { root: true });
        },
    }
}
