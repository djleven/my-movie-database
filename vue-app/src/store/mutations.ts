import {BaseTemplateSections, ContentId, ContentTypes} from "@/models/settings";
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
    addContent(state, payload: any) {
        const personCreditsKey = 'combined_credits'
        const standardisedKey = 'credits'
        if(payload[personCreditsKey]) {
            delete Object.assign(payload, {[standardisedKey]: payload[personCreditsKey] })[personCreditsKey]
        }

        Object.assign(state.content, payload)
    },
    addExtendedCredits(state, payload: any) {
        state.credits = Object.assign({}, {
            cast: {
                movie: orderCredits(
                    filterCreditsByMediaType(payload.cast, 'movie'),
                    'release_date',
                    true
                ),
                tv: orderCredits(
                    filterCreditsByMediaType(payload.cast, 'tv'),
                    'episode_count'
                )
            },
            crew: {
                movie: orderCredits(
                    filterCreditsByMediaType(payload.crew, 'movie'),
                    'release_date',
                    true
                ),
                tv: orderCredits(
                    filterCreditsByMediaType(payload.crew, 'tv'),
                    'episode_count'
                )
            }
        })
    },
    addBaseCredits(state, payload: any) {
        state.credits = Object.assign({}, {
            cast:orderCredits(payload.cast, 'order', false, false),
            crew: orderCredits(payload.crew, 'popularity', false, false)
        })
    },
    setActive(state, activeTab: BaseTemplateSections) {
        state.activeTab = activeTab
    },
    setID(state, id: ContentId) {
        state.id = id
    },
    setContentLoaded(state, status: boolean) {
        state.contentLoaded = status
    },
    setContentLoading(state,  status: boolean) {
        state.contentLoading = status
    },
}
