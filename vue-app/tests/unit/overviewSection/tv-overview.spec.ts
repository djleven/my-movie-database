import { createStore } from 'vuex'
import { mount } from '@vue/test-utils'
import { stateData, tvShowModuleData } from '../../fixtures/tvStateFixtures'

import { key } from '@/store'
import TvOverview from '@/components/tvshow/tv-overview.vue'

import OverviewSection from "@/components/common/overview-section.vue"
import SectionLayout from "@/components/common/section-layout.vue"

describe('TvOverview.vue: Render correct field data and labels in the html', () => {
  let rootComponent
  let store
  let overviewComponent
  beforeAll(() => {
    store = createStore({
      state() {
        return Object.assign(stateData, {
          tvshow: tvShowModuleData
        })
      },
      getters: {
        getFormattedDate() {
          return jest.fn().mockImplementation(() => 'August 14, 2020')
        }
      }
    })

    rootComponent = mount(TvOverview, {
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
    expect(title.text()).toBe("Ted Lasso (2020)")

  })
  it('renders the first aired date', () => {

    expect(store.getters.getFormattedDate).toHaveBeenCalled()
    const releaseDate = overviewComponent.find('.mmodb-first_air_date')
    expect(releaseDate.text()).toBe("First aired: August 14, 2020")

  })
  it('renders the description text', () => {
    const desc = overviewComponent.find('.col-md-12.overview-text')
    expect(desc.text()).toBe(
"Ted Lasso, an American football coach, moves to England when he’s hired to manage a soccer team—despite having no experience. With cynical players and a doubtful town, will he get them to see the Ted Lasso Way?"    )

  })

  it('renders the website link', () => {
    const link = overviewComponent.find('.mmodb-homepage a')
    expect(link.text()).toBe("Website")
    expect(link.attributes().href).toBe("https://tv.apple.com/show/ted-lasso/umc.cmc.vtoh0mn0xn7t3c643xqonfzy")

  })
  it('renders the production fields', () => {
    const companies = overviewComponent.find('.mmodb-production_companies')
    expect(companies.text()).toBe("Production Companies: Doozer, Warner Bros. Television, Universal Television, Ruby's Tuna")

    const networks = overviewComponent.find('.mmodb-networks')
    expect(networks.text()).toBe("Networks: Apple TV+")
  })

  it('renders all the other main fields', () => {
    const genres = overviewComponent.find('.mmodb-genres')
    expect(genres.text()).toBe("Genres: Comedy, Drama")

    const starring = overviewComponent.find('.mmodb-starring')
    expect(starring.text()).toBe("Starring: Jason Sudeikis, Hannah Waddingham, Juno Temple")

    const createdBy = overviewComponent.find('.mmodb-created_by')
    expect(createdBy.text()).toBe("Created by: Jason Sudeikis, Brendan Hunt, Bill Lawrence, Joe Kelly")

    const numberOfEpisodes = overviewComponent.find('.mmodb-number_of_episodes')
    expect(numberOfEpisodes.text()).toBe("Episodes / Seasons: 34 / 3")

    const runtime = overviewComponent.find('.mmodb-episode_run_time')
    expect(runtime.text()).toBe("Runtime: 30 min")
  })
})
