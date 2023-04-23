import BaseSearchResponse from '@/models/apiTypes/search/BaseSearchResponse'
export default interface MoviesSearchResponse extends BaseSearchResponse {
    results: MovieSearchData[]
}

export interface MovieSearchData {
    poster_path: string | null,
    adult: boolean,
    overview: string,
    release_date: Date,
    genre_ids: number[],
    id: number,
    original_language: string,
    original_title: string,
    title: string,
    backdrop_path: string | null,
    popularity: number,
    vote_average: number,
    vote_count: number,
    video: boolean
}