import { ScreenPlayCredits } from '@/models/credits'
import ScreenPlayData, { ProductionCompany } from '@/models/screenPlay'
import { orderCredits} from '@/helpers/templating'

interface CreatedByCredit {
    credit_id: string,
    gender: 1 | 2,
    id: number,
    name: string,
    profile_path: string | null
}

interface Season {
    air_date: Date,
    episode_count: number,
    id: number,
    name: string,
    overview: string,
    poster_path: string,
    season_number: number,
}


interface Episode {
    air_date: Date,
    episode_number: number,
    id: number,
    name: string,
    overview: string,
    production_code: string,
    season_number: number,
    still_path: string | null,
    vote_average: number,
    vote_count: number,
}

export interface TvShowData extends ScreenPlayData {
    created_by: CreatedByCredit[]
    episode_run_time: number[],
    first_air_date: Date,
    in_production: boolean,
    languages: string[],
    last_air_date: Date,
    last_episode_to_air: Episode | null,
    name: string,
    networks: ProductionCompany[],
    next_episode_to_air: Episode | null,
    number_of_episodes: number,
    number_of_seasons: number,
    origin_country: string[],
    original_name: string,
    seasons: Season[],
    status: string,
    tagline: string,
    type: string,
}

export interface TvShowState {
    content: TvShowData | null,
    credits: ScreenPlayCredits
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
        credits
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
                commit('setContentLoaded', true, { root: true });
            }
            commit('setErrorMessage', 'Failed to load TV Show data', { root: true });
        },
    }
}
