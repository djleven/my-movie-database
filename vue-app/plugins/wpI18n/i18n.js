// import { __, _x, _n, sprintf  } from '@wordpress/i18n'
const { __, _x, _n, sprintf  } = wp.i18n

const i18nCoreOverview = 'Overview'
const i18nCoreView = 'View'
const i18nCoreWebsite= 'Website'

export default {
// I18nCommon
    overview: __(i18nCoreOverview),
    view: __(i18nCoreView),
    cast: __('Cast', 'my-movie-database'),
    crew: __('Crew', 'my-movie-database'),
    summary: __('Summary', 'my-movie-database'),
    role: __('Role', 'my-movie-database'),
    homepage: __(i18nCoreWebsite),
    no_description: __('There is no description available', 'my-movie-database'),
    imdb_profile: __('IMDb Profile', 'my-movie-database'),
// I18nPerson
    place_of_birth: __('Birthplace', 'my-movie-database'),
    birthday: __('Birthday', 'my-movie-database'),
    birthplace: __('Birthplace', 'my-movie-database'),
    deathday: __('Died on', 'my-movie-database'),
    department: __('Department', 'my-movie-database'),
    known_for_department: _x('Known for', 'Known for refers to the department of work, ex: Known for acting or directing', 'my-movie-database'),
    also_known_as: _x('Also known as', 'Other names the person is also known as, for example Jon Stewart is "also known as" Jonathan Stuart Leibowitz', 'my-movie-database'),
    movie_cast: __('Movie Acting Roles', 'my-movie-database'),
    movie_crew: __('Movie Crew Credits', 'my-movie-database'),
    tv_cast: __('Tv Roles', 'my-movie-database'),
    tv_crew: __('Tv Crew Credits', 'my-movie-database'),
    person: {
        cast: __('Cast Credits', 'my-movie-database'),
        crew: __('Crew Credits', 'my-movie-database'),
    },
// I18nScreenPlay
    genres: __('Genres', 'my-movie-database'),
    networks: __('Networks', 'my-movie-database'),
    production_companies: __('Production Companies', 'my-movie-database'),
    min: _x('min', 'Abbreviation for the word minutes, ex: 120 min', 'my-movie-database'),
// I18nMovie
    trailer: __('Trailer', 'my-movie-database'),
    starring: __('Starring', 'my-movie-database'),
    original_language: __('Original Film Language', 'my-movie-database'),
    original_title: __('Original Title', 'my-movie-database'),
    release_date: __('Release Date', 'my-movie-database'),
    runtime: __('Runtime', 'my-movie-database'),
    production_countries: __('Production Countries', 'my-movie-database'),
// I18nTvShow
    seasons: __('Seasons', 'my-movie-database'),
    created_by: __('Created by', 'my-movie-database'),
    episodes: __('Episodes ', 'my-movie-database'),
    first_air_date: __('First aired', 'my-movie-database'),
    last_air_date: __('Last air date', 'my-movie-database'),
    episode_run_time: __('Runtime', 'my-movie-database'),
    episode_count:(count) => sprintf(_n('%s episode', '%s episodes', count, 'my-movie-database'), count),
}