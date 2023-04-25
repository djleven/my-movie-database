import BaseSearchResponse from '@/models/apiTypes/search/BaseSearchResponse'
export default interface TvShowsSearchResponse extends BaseSearchResponse {
    results: TvShowSearchData[]
}

export interface TvShowSearchData {
    poster_path: string | null,
    popularity: number,
    id: number,
    backdrop_path: string | null,
    overview: string,
    first_air_date: Date | null,
    origin_country: string[],
    genre_ids: number[],
    original_language: string,
    original_name: string,
    name: string,
    vote_average: number,
    vote_count: number,
}