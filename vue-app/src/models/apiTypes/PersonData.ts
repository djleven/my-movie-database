import { PersonCredits } from '@/models/credits'

export default interface PersonData {
    name: string,
    adult: boolean,
    backdrop_path: string | null,
    known_for_department: string,
    also_known_as: string[],
    birthday: Date | null,
    place_of_birth: string,
    combined_credits: PersonCredits,
    deathday: Date | null,
    gender: 0 | 1 | 2 | 3,
    homepage: URL | null,
    id: number,
    imdb_id: string,
    biography: string | null,
    popularity: number,
    profile_path: string | null,
}
