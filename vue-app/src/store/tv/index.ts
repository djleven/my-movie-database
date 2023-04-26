import TvShowData from '@/models/apiTypes/TvShowData'
import { ScreenPlayCredits } from '@/models/credits'
import { orderCredits} from '@/helpers/templating'
import { BaseTemplateSections } from '@/models/settings'
import { AppComponents, EntityComponents } from '@/models/templates'

export interface TvShowState {
    content: TvShowData | null
    credits: ScreenPlayCredits
    components: EntityComponents
}

const TypeComponents: EntityComponents = {
    [BaseTemplateSections.Overview]: AppComponents.TvOverview,
    [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_4]: AppComponents.TvSeasons,
}

const content: Partial<TvShowData> | null = null

const credits: ScreenPlayCredits = {
    cast: [],
    crew: []
}

export default {
    namespaced: true,
    state: (): TvShowState => ({
        content,
        credits,
        components: TypeComponents
    }),
    mutations: {
        setCredits(state, {cast, crew}: ScreenPlayCredits) {
            state.credits = Object.assign({}, {
                cast:orderCredits(cast, 'order', false, false),
                crew: orderCredits(crew, 'popularity', false, true)
            })
        },
        setContent(state, data: TvShowData) {
            state.content = Object.assign({}, data)
        },
    },
    getters: {
        contentHasCastCredits: (state) => {
            return Boolean(state.content.credits.cast.length)
        },
        contentHasCrewCredits: (state) => {
            return Boolean(state.content.credits.crew.length)
        },
        hasSectionFour: (state) => {
            return state.content?.seasons?.length
        },
        sectionFourLabelKey: () => 'seasons',
        getContentTitle: (state) => {
            return state.content?.name
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
            commit('setErrorMessage', 'Failed to load TV Show data', { root: true });
        },
    }
}
