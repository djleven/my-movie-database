import { ScreenPlayCredits } from '@/models/credits'
import ScreenPlayData from '@/models/screenPlay'
import { orderCredits} from '@/helpers/templating'
interface BelongsToCollection {
    backdrop_path: string,
    id: number,
    name: string,
    poster_path: string,
}

interface YoutubeVideo {
    name: string,
    size: string,
    source: string,
    type: string
}
export interface MovieData extends ScreenPlayData {
    belongs_to_collection: BelongsToCollection | null,
    budget: number,
    imdb_id: string | null,
    original_language: string,
    original_title: string,
    release_date: Date,
    revenue: number,
    runtime: number | null,
    status: string,
    tagline: string | null,
    title: string,
    trailers: {
        quicktime: [],
        youtube: YoutubeVideo[],
    },
    video: boolean,
}

const content: Partial<MovieData> | null = null

const credits: ScreenPlayCredits = {
    cast: [],
    crew: []
}
export interface MovieState {
    content: MovieData | null,
    credits: ScreenPlayCredits
}
export default {
    namespaced: true,
    state: (): MovieState => ({
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
