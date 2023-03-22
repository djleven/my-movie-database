import BaseSearchResponse from '@/models/searchTypes'
import { MovieSearchData } from "@/models/searchTypes/movie";
import { TvShowSearchData } from "@/models/searchTypes/tvshow";

interface KnownForMovie extends MovieSearchData {
  media_type: 'movie'
}

interface KnownForTvShow extends TvShowSearchData{
  media_type: 'tv'
}

export default interface PeopleSearchResponse extends BaseSearchResponse {
  results: PersonSearchData[]
}

export interface PersonSearchData {
  profile_path: string | null,
  adult: boolean,
  id: number,
  name: string,
  popularity: number,
  known_for: KnownForMovie[] | KnownForTvShow[],
}
