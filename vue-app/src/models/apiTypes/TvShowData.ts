import ScreenPlayData, { ProductionCompany } from '@/models/screenPlay'

interface CreatedByCredit {
    credit_id: string,
    gender: 1 | 2,
    id: number,
    name: string,
    profile_path: string | null
}

interface Season {
    air_date: Date | null,
    episode_count: number,
    id: number,
    name: string,
    overview: string,
    poster_path: string | null,
    season_number: number,
}

interface Episode {
    air_date: Date | null,
    episode_number: number,
    id: number,
    name: string,
    overview: string,
    production_code: string,
    season_number: number,
    still_path: string | null,
    vote_average: number,
    vote_count: number,
}

export default interface TvShowData extends ScreenPlayData {
    created_by: CreatedByCredit[]
    episode_run_time: number[],
    first_air_date: Date | null,
    in_production: boolean,
    languages: string[],
    last_air_date: Date | null,
    last_episode_to_air: Episode | null,
    name: string,
    networks: ProductionCompany[],
    next_episode_to_air: Episode | null,
    number_of_episodes: number,
    number_of_seasons: number,
    origin_country: string[],
    original_name: string,
    seasons: Season[],
    status: string,
    tagline: string,
    type: string,
}