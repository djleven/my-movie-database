/**
 * Abstract credit is used as a root interface for both tv/movie (ScreenPlay) and person (Person) models
 */
interface AbstractCredit {
    credit_id: string
    id: number
    adult: boolean,
    name: string
    original_name: string
    popularity: number
}

/**
 * ScreenPlay credits reference response models for tv and movie endpoints
 */
interface ScreenPlayCredit extends AbstractCredit {
    gender: number
    known_for_department: string
    profile_path: string
}

export interface ScreenPlayCastCredit extends ScreenPlayCredit {
    character: string
    order: number
    // cast_id  is only available for movies (only difference between movie and tv)
    cast_id?: number
}
export interface ScreenPlayCrewCredit extends ScreenPlayCredit {
    department: string
    job: string
}

export type ScreenPlayCredits = {
    cast: ScreenPlayCastCredit[]
    crew: ScreenPlayCrewCredit[]
}

/**
 * Person credits reference response models for person endpoints
 */
interface PersonCredit extends AbstractCredit {
    original_language: string
    episode_count: number
    overview: string
    origin_country: [string]
    genre_ids: [number]
    media_type: string
    poster_path: string | null
    first_air_date: string
    vote_average: number
    vote_count: number
    backdrop_path: string | null
    original_title: string
    video: boolean
    release_date: string
    title: string
}
export interface PersonCastCredit extends PersonCredit {
    character: string
}
export interface PersonCrewCredit extends PersonCredit {
    department: string
    job: string
}

export type PersonCredits = {
    // id: number,
    cast: PersonCastCredit[]
    crew: PersonCrewCredit[]
}

export enum ScreenPlayTypes {
    Movie= 'movie',
    Tv= 'tv'
}

export type PersonCreditsByScreenPlayType = {
    cast: {
        [ScreenPlayTypes.Movie]: PersonCastCredit[],
        [ScreenPlayTypes.Tv]: PersonCastCredit[],
    }
    crew: {
        [ScreenPlayTypes.Movie]: PersonCrewCredit[],
        [ScreenPlayTypes.Tv]: PersonCrewCredit[],
    }
}

export type CreditCollectionType = ScreenPlayCrewCredit[] | ScreenPlayCastCredit[] | PersonCastCredit[] | PersonCrewCredit[]


