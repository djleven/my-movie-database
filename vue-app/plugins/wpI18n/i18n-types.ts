export interface I18nCommon {
    overview: string
    view: string
    cast: string
    crew: string
    summary: string
    homepage: string
    role: string
    no_description: string
}

export interface I18nPerson extends I18nCommon {
    place_of_birth: string
    birthday: string
    birthplace: string
    death_date: string
    department: string
    known_for_department: string
    also_known_as: string
    movie_cast: string
    movie_crew: string
    tv_cast: string
    tv_crew: string
    imdb_profile: string
    episode_count: string
}

export interface I18nScreenPlay extends I18nCommon {
    genres: string
    production_companies: string
    networks: string
    min: string
}

export interface I18nMovie extends I18nScreenPlay {
    trailer: string
    starring: string
    directing: string
    original_language: string
    original_title: string
    release_date: string
    imdb_profile: string
    runtime: string
    production_countries: string
}

export interface I18nTvShow extends I18nScreenPlay {
    seasons: string
    created_by: string
    episodes: string
    number_of_episodes: string
    first_air_date: string
    last_air_date: string
    episode_run_time: string
    air_date: string
    episode_count: string
}
