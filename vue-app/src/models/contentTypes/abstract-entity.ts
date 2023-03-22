import { BaseTemplateSections } from '@/models/settings'
import { AppComponents } from '@/models/templates'
import { MovieState } from '@/store/movie'
import { TvShowState } from '@/store/tv'
import { PersonState } from '@/store/person'
import { I18Movie } from '@/models/contentTypes/movie'
import { I18TvShow } from '@/models/contentTypes/tvshow'
import { I18Person } from '@/models/contentTypes/person'

export type EntityComponents = Partial<Record<BaseTemplateSections, AppComponents>>

export type I18Entities = I18Person | I18TvShow | I18Movie

export default abstract class AbstractEntity {
    public components: EntityComponents;
    public __t: I18Entities;

    constructor (
        components: EntityComponents = {},
        __t: Partial<I18Entities> = {},
    ) {
        this.components = {
            ...this.getDefaultComponents(),
            ...components
        }
        this.__t = {
            ...this.getDefaultTranslations(),
            ...__t
        }
    }

    abstract getDefaultComponents(): EntityComponents
    abstract getDefaultTranslations(): I18Entities
    abstract getInitialState(): MovieState | TvShowState | PersonState
}