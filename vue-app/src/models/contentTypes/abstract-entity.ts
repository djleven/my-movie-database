import { BaseTemplateSections } from "@/models/settings";
import { AppComponents } from "@/models/templates";
import {MovieState} from "@/store/movie";
import {TvShowState} from "@/store/tv";
import {PersonState} from "@/store/person";

export type EntityComponents = Partial<Record<BaseTemplateSections, AppComponents>>

export type I18EntityCollection = Record<string, string>

export default abstract class AbstractEntity {
    public components: EntityComponents;
    public __t: I18EntityCollection;

    constructor (
        components: EntityComponents = {},
        __t: I18EntityCollection = {},
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
    abstract getInitialState(): MovieState | TvShowState | PersonState
}