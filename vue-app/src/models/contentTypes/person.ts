import AbstractEntity, {EntityComponents, I18EntityCollection, AppComponents} from './abstract-entity'
import {BaseTemplateSections} from "@/models/settings";

const TypeComponents: EntityComponents = {
  [BaseTemplateSections.Overview]: AppComponents.PersonOverview,
  [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
  [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
}

const default__t: I18EntityCollection = {
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

  getDefaultComponents(): EntityComponents {
    return TypeComponents
  }
  getDefaultTranslations(): I18EntityCollection  {
    return default__t
  }
}