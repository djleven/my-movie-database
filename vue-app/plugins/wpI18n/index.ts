import { App } from 'vue'
import translations from './i18n.js'

export type TranslationParams = {
    count?: number,
    replacements?: string[] | number[]
}
export default {
    install: (app:App) => {
        const $t = (key: string, replacements?: string[] | number[]) => {
            if(!key) {
                return
            }
            if (replacements?.length) {
                return translateWithReplacements(key, replacements)
            }

            return translate(key)
        }
        const $tc = (key: string, count: number) => {
            if(!key) {
                return
            }
            return translateWithCount(key, count)
        }
        app.provide('$t', $t);
        app.provide('$tc', $tc);
    }
}

const getValueFromPath = (path: string[]) => {
    return path.reduce((record, item) => record[item], translations);
}

const translate = (key: string) => {
    const path = key.split('.')
    const result = getValueFromPath(path)

    if(typeof result === 'undefined') {
        console.log(`Error finding translation for key: ${key}`)
    }

    return result ?? key
}

const translateWithReplacements = (key: string, replacements: string[] | number[]): string | Function | undefined => {
    const result = translateWithParam(key, { replacements })

    if(typeof result === 'undefined') {
        console.log(`Error finding replacements translation for key: ${key}`)
    }

    return result ?? key
}

const translateWithCount = (key: string, count: number): string | Function | undefined => {
    const result = translateWithParam(key, { count })

    if(typeof result === 'undefined') {
        console.log(`Error finding count translation for key: ${key}`)
    }

    return result ?? key
}

const translateWithParam = (key: string, params: TranslationParams):  string | Function | undefined => {
    const i18nMethod = translate(key)
    if(typeof i18nMethod === 'function') {
        return params.replacements ? i18nMethod(params.replacements) : i18nMethod(params.count)
    }

    return 'undefined'
}
