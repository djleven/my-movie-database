import AbstractEntity, {AppComponents, EntityComponents, I18EntityCollection} from './abstract-entity'
import {BaseTemplateSections} from "@/models/settings";

const TypeComponents: EntityComponents = {
    [BaseTemplateSections.Overview]: AppComponents.PersonOverview,
    [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_4]: AppComponents.MovieTrailer,
}

const default__t: I18EntityCollection = {
    "overview": "Overview",
    "view": "View",
    "cast": "Cast",
    "crew": "Crew",
    "trailer": "Trailer",
    "section_4": "Trailer",
    "summary": "Summary",
    "genres": "Genres",
    "starring": "Starring",
    "original_language": "Original Film Language",
    "original_title": "Original Title",
    "release_date": "Release Date",
    "imdb_profile": "Imdb Profile",
    "homepage": "Website",
    "runtime": "Runtime",
    "networks": "Networks",
    "production_companies": "Production Companies",
    "production_countries": "Production Countries",
    "min": "min",
    "role": "Role"
}

export default class Movie extends AbstractEntity {

    getDefaultComponents(): EntityComponents {
        return TypeComponents
    }
    getDefaultTranslations(): I18EntityCollection  {
        return default__t
    }
}