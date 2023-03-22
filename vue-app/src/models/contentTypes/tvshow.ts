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

export type I18TvShow = {
    overview: string,
    view: string,
    cast: string,
    crew: string,
    seasons: string,
    summary: string,
    genres: string,
    created_by:   string,
    starring: string,
    number_of_episodes: string,
    first_air_date: string,
    last_air_date: string,
    homepage: string,
    episode_run_time: string,
    networks: string,
    production_companies: string,
    min: string,
    role: string,
    section_4: string,
    air_date: string,
    episode_count: string,
    no_description: string
}

const default__t: I18TvShow = {
    "overview": "Overview",
    "view": "View",
    "cast": "Cast",
    "crew": "Crew",
    "seasons": "Seasons",
    "summary": "Summary",
    "genres": "Genres",
    "created_by": "Created by",
    "starring": "Starring",
    "number_of_episodes": "Episodes / Seasons",
    "first_air_date": "First aired",
    "last_air_date": "Last air date",
    "homepage": "Website",
    "episode_run_time": "Runtime",
    "networks": "Networks",
    "production_companies": "Production Companies",
    "min": "min",
    "role": "Role",
    "section_4": "Seasons",
    "air_date": "Air date",
    "episode_count": "Episodes",
    "no_description": "There is no season description available"
}

export default class Tvshow extends AbstractEntity {

    getDefaultComponents(): EntityComponents {
        return TypeComponents
    }
    getDefaultTranslations(): I18TvShow  {
        return default__t
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