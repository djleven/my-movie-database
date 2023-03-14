import {BaseTemplateSections} from "@/models/settings";

export enum AppComponents {
    MovieOverview = 'MovieOverview',
    TvOverview ='TvOverview',
    PersonOverview = 'PersonOverview',
    CastCrew = 'CastCrew',
    MovieTrailer = 'MovieTrailer',
    TvSeasons = 'TvSeasons',
}

export type EntityComponents = Partial<Record<BaseTemplateSections, AppComponents>>

export type I18EntityCollection = Record<string, string>

export default abstract class AbstractEntity {
    public components: EntityComponents;
    public __t: I18EntityCollection;
    constructor (
        components: EntityComponents = {},
        __t: I18EntityCollection = {}
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
    abstract getDefaultTranslations(): I18EntityCollection
}