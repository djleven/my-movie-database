import { createStore } from 'vuex'
import { mount } from '@vue/test-utils'

import { key } from '@/store'
import { stateData, personModuleData } from '../../fixtures/personStateFixtures'

import PersonOverview from '@/components/person/person-overview.vue'
import OverviewSection from "@/components/common/overview-section.vue"
import SectionLayout from "@/components/common/section-layout.vue"

describe('PersonOverview.vue: Render correct field data and labels in the html', () => {
  let rootComponent
  let store
  let overviewComponent
  beforeAll(() => {
    store = createStore({
      state() {
        return Object.assign(stateData, {
          person: personModuleData
        })
      },
      getters: {
        getFormattedDate() {
          return jest.fn().mockImplementation(() => 'June 28, 1966')
        }
      }
    })

    rootComponent = mount(PersonOverview, {
      global: {
        components: {OverviewSection, SectionLayout},
        plugins: [[store, key]],
      }
    })

    overviewComponent = rootComponent.findComponent(OverviewSection)
    expect(overviewComponent.exists()).toBe(true)
  })
  it('renders the correct title', () => {

    const title = overviewComponent.find('h1')
    expect(title.text()).toBe("John Cusack")

  })
  it('renders the birth date', () => {

    expect(store.getters.getFormattedDate).toHaveBeenCalled()
    const birthDay = overviewComponent.find('.mmodb-birthday')
    expect(birthDay.text()).toBe("Birthday: June 28, 1966")

  })
  it('renders the description text', () => {
    const desc = overviewComponent.find('.col-md-12.overview-text')
    expect(desc.text()).toBe(
        "John Paul Cusack (born June 28, 1966 - Height: 6' 2½\") is an American film actor and screenwriter. He has appeared in more than 50 films, including The Journey of Natty Gann, Say Anything..., Grosse Point Blank, Con Air, High Fidelity, and 2012. His father, Richard Cusack (1925–2003), was an actor, as are his siblings: Ann, Joan, Bill, and Susie. His father was also a documentary filmmaker, owned a film production company, and was a friend of activist Philip Berrigan. Cusack spent a year at New York University before dropping out, saying that he had \"too much fire in [his] belly\". Cusack is a fan of both the Chicago Cubs and the Chicago White Sox, for which, he says, he is \"in trouble there\". He has led the crowd in a performance of \"Take Me Out to the Ball Game\" at Wrigley Field. He has also been spotted at multiple Chicago Bears games, and attended many of the Stanley Cup Finals games in support of the Chicago Blackhawks. Cusack has trained in kickboxing for over 20 years, under former world kickboxing champion Benny Urquidez. He began training under Urquidez in preparation for his role in Say Anything... and currently holds the rank of a level 6 black belt in Urquidez's Ukidokan Kickboxing system."
    )
  })

  it('renders the website link', () => {
    // const link = overviewComponent.find('.mmodb-homepage a')
    // expect(link.text()).toBe("Website")
    // expect(link.attributes().href).toBe("http://www.example.com/")

  })
  it('renders the credit count fields', () => {
    const movieCastCount = overviewComponent.find('.mmodb-movie_cast')
    expect(movieCastCount.text()).toBe("Movie Acting Roles: 10")

    const tvCastCount = overviewComponent.find('.mmodb-tv_cast')
    expect(tvCastCount.text()).toBe("Tv Roles: 10")

    const movieCrewCount = overviewComponent.find('.mmodb-movie_crew')
    expect(movieCrewCount.text()).toBe("Movie Crew Credits: 10")

    // const tvCrewCount = overviewComponent.find('.mmodb-tv_crew')
    // expect(tvCrewCount.text()).toBe("Movie Acting Roles: 99")
  })

  it('renders all the other main fields', () => {
    const knownFor = overviewComponent.find('.mmodb-known_for_department')
    expect(knownFor.text()).toBe("Known for: Acting")

    const knownAs = overviewComponent.find('.mmodb-also_known_as')
    expect(knownAs.text()).toBe("Also known as: John Cusak")

    const birthPlace = overviewComponent.find('.mmodb-place_of_birth')
    expect(birthPlace.text()).toBe("Birthplace: Evanston, Illinois, USA")

  })
})
