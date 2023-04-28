import PersonData from '@/models/apiTypes/PersonData'
import {
    PersonCastCredit,
    PersonCredits,
    PersonCreditsByScreenPlayType,
    PersonCrewCredit,
    ScreenPlayTypes,
} from '@/models/credits'
import { orderCredits, removeDuplicatesAndAggregateCredits } from '@/helpers/templating'
import { AppComponents, EntityComponents } from '@/models/templates'
import { BaseTemplateSections } from '@/models/settings'

export interface PersonState {
    content: PersonData | null
    credits: PersonCreditsByScreenPlayType
    components: EntityComponents
}

const TypeComponents: EntityComponents = {
    [BaseTemplateSections.Overview]: AppComponents.PersonOverview,
    [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
}

const content: Partial<PersonData> | null = null

const credits: PersonCreditsByScreenPlayType = {
    cast: {
        [ScreenPlayTypes.Movie]: [],
        [ScreenPlayTypes.Tv]: [],
    },
    crew: {
        [ScreenPlayTypes.Movie]: [],
        [ScreenPlayTypes.Tv]: [],
    }
}

const filterCreditsByMediaType = (credits: PersonCastCredit[] | PersonCrewCredit[], filter: ScreenPlayTypes) => {
    // https://github.com/microsoft/TypeScript/issues/44373
    return (credits as []).filter((credit: PersonCastCredit | PersonCrewCredit) => {
        if(credit.media_type  === filter) {
            return credit
        }
    });
}

export default {
    namespaced: true,
    state: (): PersonState => ({
        content,
        credits,
        components: TypeComponents
    }),
    mutations: {
        setCredits(state, {cast, crew}: PersonCredits) {
            state.credits = Object.assign({}, {
                cast: {
                    movie: orderCredits(
                        filterCreditsByMediaType(cast, ScreenPlayTypes.Movie),
                        'release_date',
                        true
                    ),
                    tv: orderCredits(
                        filterCreditsByMediaType(cast, ScreenPlayTypes.Tv),
                        'episode_count'
                    )
                },
                crew: {
                    movie: removeDuplicatesAndAggregateCredits(
                        orderCredits(
                            filterCreditsByMediaType(crew, ScreenPlayTypes.Movie),
                            'release_date',
                            true
                        )
                    ),
                    tv: removeDuplicatesAndAggregateCredits(
                        orderCredits(
                            filterCreditsByMediaType(crew, ScreenPlayTypes.Tv),
                            'episode_count'
                        )
                    )
                }
            })
            console.log(state)
        },
        setContent(state, data: PersonData) {
            state.content = Object.assign({}, data)
        },
    },
    getters: {
        contentHasCastCredits: (state) => {
            return Boolean(state.content.combined_credits.cast.length)
        },
        contentHasCrewCredits: (state) => {
            return Boolean(state.content.combined_credits.crew.length)
        },
        hasSectionFour: () => false,
        sectionFourLabelKey: () => '',
        getContentTitle: (state) => {
            return state.content.name
        },
        getImagePath: (state)  => {
            return state.content?.profile_path
        }
    },
    actions: {
        setContentLoaded({state, commit}) {
            if(state.content !== null) {
                return commit('setContentLoaded', true, { root: true });
            }
            commit('setErrorMessage', 'Failed to load Person data', { root: true });
        },
    }
}
