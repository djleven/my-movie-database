import AbstractEntity, {AppComponents, EntityComponents, I18EntityCollection} from './abstract-entity'
import {BaseTemplateSections} from "@/models/settings";

const TypeComponents: EntityComponents = {
    [BaseTemplateSections.Overview]: AppComponents.TvOverview,
    [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
    [BaseTemplateSections.Section_4]: AppComponents.TvSeasons,
}

const default__t: I18EntityCollection = {
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
    getDefaultTranslations(): I18EntityCollection  {
        return default__t
    }
}