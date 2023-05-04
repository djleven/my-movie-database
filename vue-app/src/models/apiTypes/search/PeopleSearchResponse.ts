import BaseSearchResponse from '@/models/apiTypes/search/BaseSearchResponse'
import { MovieSearchData } from '@/models/apiTypes/search/MoviesSearchResponse'
import { TvShowSearchData } from '@/models/apiTypes/search/TvShowsSearchResponse'

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
