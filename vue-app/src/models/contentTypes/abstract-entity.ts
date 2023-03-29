import { BaseTemplateSections } from '@/models/settings'
import { AppComponents } from '@/models/templates'
import { MovieState } from '@/store/movie'
import { TvShowState } from '@/store/tv'
import { PersonState } from '@/store/person'

export type EntityComponents = Partial<Record<BaseTemplateSections, AppComponents>>

export default abstract class AbstractEntity {
    public components: EntityComponents;

    constructor (
        components: EntityComponents = {},
    ) {
        this.components = {
            ...this.getDefaultComponents(),
            ...components
        }
    }

    abstract getDefaultComponents(): EntityComponents
    abstract getInitialState(): MovieState | TvShowState | PersonState
}