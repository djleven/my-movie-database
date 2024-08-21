// import { __, _n, sprintf  } from '@wordpress/i18n'
const { __, _n, sprintf  } = wp.i18n

export default {
// I18nCommon
    overview: __('Overview', 'my-movie-database'),
    cast: __('Cast', 'my-movie-database'),
    crew: __('Crew', 'my-movie-database'),
    /* translators: Acting role */
    role: __('Role', 'my-movie-database'),
    homepage: __('Website', 'my-movie-database'),
    no_description: __('There is no description available', 'my-movie-database'),
    /* translators: %s: Brand / Company website, ex: IMDb, TMDb, Rotten Tomatoes, etc */
    imdb_profile: sprintf(__('%s Profile', 'my-movie-database'), 'IMDb'),
// I18nPerson
    place_of_birth: __('Place of birth', 'my-movie-database'),
    birthday: __('Birthday', 'my-movie-database'),
    birthplace: __('Place of birth', 'my-movie-database'),
    deathday: __('Died on', 'my-movie-database'),
    department: __('Department', 'my-movie-database'),
    /* translators: Refers to the department of work, ex: Known for acting or directing. */
    known_for_department: __('Known for', 'my-movie-database'),
    /* translators: Other names the person is also known as, for example Jon Stewart is "also known as" Jonathan Stuart Leibowitz. */
    also_known_as: __('Also known as', 'my-movie-database'),
    movie_cast: __('Movie roles', 'my-movie-database'),
    movie_crew: __('Movie crew credits', 'my-movie-database'),
    tv_cast: __('Tv roles', 'my-movie-database'),
    tv_crew: __('Tv crew credits', 'my-movie-database'),
    person: {
        cast: __('Cast credits', 'my-movie-database'),
        crew: __('Crew credits', 'my-movie-database'),
    },
// I18nScreenPlay
    genres: __('Genres', 'my-movie-database'),
    /* translators: Movie and tv networks */
    networks: __('Networks', 'my-movie-database'),
    production_companies: __('Production companies', 'my-movie-database'),
    /* translators: Abbreviation for the word minutes, ex: 120 min. */
    min: __('min', 'my-movie-database'),
// I18nMovie
    trailer: __('Trailer', 'my-movie-database'),
    starring: __('Starring', 'my-movie-database'),
    directing: __('Directing', 'my-movie-database'),
    original_language: __('Original film language', 'my-movie-database'),
    original_title: __('Original title', 'my-movie-database'),
    release_date: __('Release date', 'my-movie-database'),
    /* translators: Duration of tv show episode or movie. */
    runtime: __('Runtime', 'my-movie-database'),
    production_countries: __('Production countries', 'my-movie-database'),
// I18nTvShow
    seasons: __('Seasons', 'my-movie-database'),
    created_by: __('Created by', 'my-movie-database'),
    episodes: __('Episodes', 'my-movie-database'),
    first_air_date: __('First aired', 'my-movie-database'),
    last_air_date: __('Last air date', 'my-movie-database'),
    /* translators: Duration of tv show episode or movie. */
    episode_run_time: __('Runtime', 'my-movie-database'),
    /* translators: %s: Number of episodes. */
    episode_count:(count) => sprintf(_n('%s episode', '%s episodes', count, 'my-movie-database'), count),
    /* translators: %s: Season number of tv show. */
    season_numbered:(number) => sprintf(__('Season %s', 'my-movie-database'), number),
}