import AbstractEntity from './abstract-entity'

const default_components = {
    overview: 'TvOverview',
    section_2: 'CastCrew',
    section_3: 'CastCrew',
    section_4: 'TvSeasons'
}

const default__t = {
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

    getComponents(){
        return default_components
    }
    getTranslations(){
        return default__t
    }
}