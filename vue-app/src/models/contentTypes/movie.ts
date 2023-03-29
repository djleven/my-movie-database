import AbstractEntity, { EntityComponents } from '@/models/contentTypes/abstract-entity'
import { BaseTemplateSections } from '@/models/settings'
import { AppComponents } from '@/models/templates'
import { MovieState } from '@/store/movie'

const TypeComponents: EntityComponents = {
    [BaseTemplateSections.Overview]: AppComponents.MovieOverview,
    [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_4]: AppComponents.MovieTrailer,
}

export default class Movie extends AbstractEntity {

    getDefaultComponents(): EntityComponents {
        return TypeComponents
    }
    getInitialState(): MovieState {
        return {
            content: null,
            credits: {
                crew: [],
                cast: []
            }
        }
    }
}