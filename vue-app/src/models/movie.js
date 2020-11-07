import AbstractEntity from './abstract-entity'

const default_components = {
    overview: 'MovieOverview',
    section_2: 'CastCrew',
    section_3: 'CastCrew',
    section_4: 'MovieTrailer'
}

const default__t = {
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

    getComponents(){
        return default_components
    }
    getTranslations(){
        return default__t
    }
}