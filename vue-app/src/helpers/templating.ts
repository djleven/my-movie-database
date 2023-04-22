import { CreditCollectionType } from '@/models/credits'
import { Color } from '@/models/settings'

export const getTitleWithYear = (title, date) => {
    const year = new Date(date).getFullYear()
    if(year) {
        return `${title} (${year})`
    }
    return title
}
export const getPropertyAsCsvFromObjectArray = (objArray, prop = 'name') => {
    if(Array.isArray(objArray)) {
        objArray = objArray.map((x) => {
            return x[prop]
        })

        return objArray.join(', ')
    }
}
export const getExcerpt = (text, maxLen) => {
    if(text.length > maxLen) {
        return `${tidyExcerpt(text, maxLen)} ...`
    }

    return text
}
const tidyExcerpt = (text, maxLen, separator = ' ') => {
    if (text.length <= maxLen) {
        return text;
    }
    return text.substr(0, text.lastIndexOf(separator, maxLen));
}

export const orderCredits = (credits: CreditCollectionType, comparison: string, date = false, desc = true) => {
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

export const setStyleColors = (bg: Color, font: Color) => `background-color: ${bg}; color: ${font};`
