import {movieCastCredits, movieCrewCredits, tvCrewCredits, tvCastCredits} from "./personCreditsFixtures";

export const castState = {
    movie: movieCastCredits,
    tv: tvCastCredits
}
export const crewState =  {
    movie: movieCrewCredits,
    tv: tvCrewCredits
}
export const contentState = {
    adult: false,
    also_known_as: ["John Cusak"],
    biography: "John Paul Cusack (born June 28, 1966 - Height: 6' 2½\") is an American film actor and screenwriter. He has appeared in more than 50 films, including The Journey of Natty Gann, Say Anything..., Grosse Point Blank, Con Air, High Fidelity, and 2012. His father, Richard Cusack (1925–2003), was an actor, as are his siblings: Ann, Joan, Bill, and Susie. His father was also a documentary filmmaker, owned a film production company, and was a friend of activist Philip Berrigan. Cusack spent a year at New York University before dropping out, saying that he had \"too much fire in [his] belly\". Cusack is a fan of both the Chicago Cubs and the Chicago White Sox, for which, he says, he is \"in trouble there\". He has led the crowd in a performance of \"Take Me Out to the Ball Game\" at Wrigley Field. He has also been spotted at multiple Chicago Bears games, and attended many of the Stanley Cup Finals games in support of the Chicago Blackhawks. Cusack has trained in kickboxing for over 20 years, under former world kickboxing champion Benny Urquidez. He began training under Urquidez in preparation for his role in Say Anything... and currently holds the rank of a level 6 black belt in Urquidez's Ukidokan Kickboxing system.",
    birthday: "1966-06-28",
    credits: {cast: movieCastCredits.concat(tvCastCredits), crew:  movieCrewCredits.concat(tvCrewCredits)},
    deathday: null,
    gender: 2,
    homepage: null,
    id: 3036,
    imdb_id: "nm0000131",
    known_for_department: "Acting",
    name: "John Cusack",
    place_of_birth: "Evanston, Illinois, USA",
    popularity: 20.384,
    profile_path: "/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg",
}
export const i18State = {
    overview: "Overview",
    view: "View",
    cast: "Cast",
    crew: "Crew",
    summary: "Summary",
    place_of_birth: "Birthplace",
    birthday: "Birthday",
    birthplace: "Birthplace",
    death_date: "Death date",
    department: "Department",
    known_for_department: "Known for",
    also_known_as: "Also known as",
    movie_cast: "Movie Acting Roles",
    movie_crew: "Movie Crew Credits",
    tv_cast: "Tv Roles",
    tv_crew: "Tv Crew Credits",
    tv_roles_full: "Tv Roles/Appearances",
    imdb_profile: "Imdb Profile",
    homepage: "Website",
    role: "Role",
    episode_count: "Episodes",
    no_description: "There is no description available"
}

export const stateData = {
    activeSection: "overview",
    components: {
        overview: "MovieOverview",
        section_2: "CastCrew",
        section_3: "CastCrew",
    },
    contentLoaded: true,
    contentLoading: false,
    cssClasses: {
        bodyColor: "#f42253",
        headerColor: "#6cce37",
        multipleColumn: "col-lg-3 col-md-3 col-sm-6",
        transitionEffect: "fade",
        twoColumn: "col-lg-6 col-md-6 col-sm-6",
    },
    global_conf: {
        date_format: "F j, Y",
        debug: "1",
        locale: "en_US",
        overviewOnHover: true,
    },
    id: "603",
    placeholder: {
        large: "http://localhost/wp-content/plugins/my-movie-database/mmdb_templates/assets/img/cinema300.png",
        medium: "http://localhost/wp-content/plugins/my-movie-database/mmdb_templates/assets/img/cinema185.png",
        small: "http://localhost/wp-content/plugins/my-movie-database/mmdb_templates/assets/img/cinema.png",
    },
    showSettings: {
        overview_text: true,
        section_2: true,
        section_3: true,
        section_4: true,
    },
    template: "tabs",
    type: "person",
}

export const personModuleData = {
    content: contentState,
    credits: {
        cast: castState,
        crew: crewState
    },
}