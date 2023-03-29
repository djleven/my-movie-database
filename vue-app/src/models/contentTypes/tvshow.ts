import AbstractEntity, { EntityComponents } from '@/models/contentTypes/abstract-entity'
import { BaseTemplateSections } from '@/models/settings'
import { AppComponents } from '@/models/templates'
import { TvShowState } from '@/store/tv'

const TypeComponents: EntityComponents = {
    [BaseTemplateSections.Overview]: AppComponents.TvOverview,
    [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_4]: AppComponents.TvSeasons,
}

export default class Tvshow extends AbstractEntity {

    getDefaultComponents(): EntityComponents {
        return TypeComponents
    }
    getInitialState(): TvShowState {
        return {
            content: null,
            credits: {
                crew: [],
                cast: []
            }
        }
    }
}