import { ScreenPlayCredits } from "@/models/credits";

interface Genre {
    id: number,
    name: string,
}
export interface ProductionCompany {
    id: number,
    logo_path: string,
    name: string,
    origin_country: string,
}

interface ProductionCountry {
    iso_3166_1: string,
    name: string,
}
interface SpokenLanguage {
    english_name: string,
    iso_639_1: string,
    name: string,
}

export default interface ScreenPlayData  {
    adult: boolean,
    backdrop_path: string | null,
    credits: ScreenPlayCredits,
    genres: Genre[],
    homepage: URL | null,
    id: number,
    original_language: string,
    overview: string | null,
    popularity: number,
    poster_path: string | null,
    production_companies: ProductionCompany[],
    production_countries: ProductionCountry[],
    spoken_languages: SpokenLanguage[],
    vote_average: number,
    vote_count: number,
}