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

export type I18Movie = {
    overview: string,
    view: string,
    cast: string,
    crew: string,
    trailer: string,
    section_4: string,
    summary: string,
    genres: string,
    starring: string,
    original_language: string,
    original_title: string,
    release_date: string,
    imdb_profile: string,
    homepage: string,
    runtime: string,
    networks: string,
    production_companies: string,
    production_countries: string,
    min: string,
    role: string
}

const default__t: I18Movie = {
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
    getDefaultTranslations(): I18Movie  {
        return default__t
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