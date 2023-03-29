export default {
    getFormattedDate: (state) => (date) => {
        const format = state.global_conf.date_format
        let locale = state.global_conf.locale.substring(0, 2)
        let month: "numeric" | "2-digit" | "long" | "short" | "narrow" | undefined = 'numeric'
        if (!date) {
            return null
        }
        if (format === 'Y-m-d') {
            locale = 'en-CA'
        } else if (format === 'd/m/Y') {
            locale = 'fr-FR'
        } else if (format === 'm/d/Y') {
            locale = 'en-US'
        } else {
            month = 'long';
        }
        return new Date(date).toLocaleDateString(
            locale,
            {
                day: '2-digit',
                month: month,
                year: 'numeric',
                timeZone: 'UTC',
            }
        );
    },
    contentHasCastCredits: (state, getters) => {
        return getters[`${state.type}/contentHasCastCredits`]
    },
    contentHasCrewCredits: (state, getters) => {
        return getters[`${state.type}/contentHasCrewCredits`]
    },
    hasSectionFour: (state, getters) => {
        return getters[`${state.type}/hasSectionFour`]
    },
    sectionFourLabelKey: (state, getters) => {
        return getters[`${state.type}/sectionFourLabelKey`]
    },
    getContentTitle: (state, getters)  => {
        return getters[`${state.type}/getContentTitle`]
    },
    getImagePath: (state, getters)  => {
        return getters[`${state.type}/getImagePath`]
    }
}
