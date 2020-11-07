import AbstractEntity from './abstract-entity'

const default_components = {
  overview: 'PersonOverview',
  section_2: 'CastCrew',
  section_3: 'CastCrew',
}

const default__t = {
  "overview": "Overview",
  "view": "View",
  "cast": "Cast",
  "crew": "Crew",
  "summary": "Summary",
  "place_of_birth": "Birthplace",
  "birthday": "Birthday",
  "birthplace": "Birthplace",
  "death_date": "Death date",
  "department": "Department",
  "known_for_department": "Known for",
  "also_known_as": "Also known as",
  "movie_cast": "Movie Acting Roles",
  "movie_crew": "Movie Crew Credits",
  "tv_cast": "Tv Roles",
  "tv_crew": "Tv Crew Credits",
  "tv_roles_full": "Tv Roles/Appearances",
  "imdb_profile": "Imdb Profile",
  "homepage": "Website",
  "role": "Role",
  "episode_count": "Episodes",
  "no_description": "There is no description available"
}


export default class Person extends AbstractEntity {

  getComponents(){
    return default_components
  }
  getTranslations(){
    return default__t
  }
}