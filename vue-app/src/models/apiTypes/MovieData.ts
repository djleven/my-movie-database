import ScreenPlayData from '@/models/screenPlay'

interface BelongsToCollection {
    backdrop_path: string | null,
    id: number,
    name: string,
    poster_path: string | null,
}

interface YoutubeVideo {
    name: string,
    size: string | null,
    source: string,
    type: string
}

export default interface MovieData extends ScreenPlayData {
    belongs_to_collection: BelongsToCollection | null,
    budget: number,
    imdb_id: string | null,
    original_language: string,
    original_title: string,
    release_date: Date | null,
    revenue: number,
    runtime: number | null,
    status: string,
    tagline: string | null,
    title: string,
    trailers: {
        youtube: YoutubeVideo[],
    },
    video: boolean,
}