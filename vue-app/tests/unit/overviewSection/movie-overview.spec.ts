import { createStore } from 'vuex'
import { mount } from '@vue/test-utils'
import { stateData } from '../../fixtures/movieStateFixtures'

import MovieOverview from '@/components/movie/movie-overview.vue'
import Overview from "@/components/common/overview-section.vue"
import SectionLayout from "@/components/common/section-layout.vue"

describe('MovieOverview.vue: Render correct field data and labels in the html', () => {
  let rootComponent
  let store
  let overviewComponent
  beforeAll(() => {
    store = createStore({
      state() {
        return stateData
      },
      getters: {
        getFormattedDate() {
          return jest.fn().mockImplementation(() => 'March 30, 1999')
        }
      }
    })

    rootComponent = mount(MovieOverview, {
      global: {
        components: {Overview, SectionLayout},
        plugins: [store],
      }
    })

    overviewComponent = rootComponent.findComponent(Overview)
    expect(overviewComponent.exists()).toBe(true)

  })
  it('renders the correct title', () => {

    const title = overviewComponent.find('h1')
    expect(title.text()).toBe("The Matrix (1999)")

  })
  it('renders the release date', () => {

    expect(store.getters.getFormattedDate).toHaveBeenCalled()
    const releaseDate = overviewComponent.find('.mmodb-release_date')
    expect(releaseDate.text()).toBe("Release Date: March 30, 1999")

  })
  it('renders the description text', () => {
    const desc = overviewComponent.find('.col-md-12.overview-text')
    expect(desc.text()).toBe("Set in the 22nd century, The Matrix tells the story of a computer hacker who joins a group of underground insurgents fighting the vast and powerful computers who now rule the earth.")

  })

  it('renders the website link', () => {
    const desc = overviewComponent.find('.mmodb-homepage a')
    expect(desc.text()).toBe("Website")
    expect(desc.attributes().href).toBe("http://www.warnerbros.com/matrix")

  })
  it('renders the production fields', () => {
    const companies = overviewComponent.find('.mmodb-production_companies')
    expect(companies.text()).toBe("Production Companies: Village Roadshow Pictures, Groucho II Film Partnership, Silver Pictures, Warner Bros. Pictures")

    const countries = overviewComponent.find('.mmodb-production_countries')
    expect(countries.text()).toBe("Production Countries: United States of America")
  })

  it('renders all the other main fields', () => {
    const starring = overviewComponent.find('.mmodb-starring')
    expect(starring.text()).toBe("Starring: Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss")

    const genres = overviewComponent.find('.mmodb-genres')
    expect(genres.text()).toBe("Genres: Action, Science Fiction")

    const runtime = overviewComponent.find('.mmodb-runtime')
    expect(runtime.text()).toBe("Runtime: 136 min")

    const originalTitle = overviewComponent.find('.mmodb-original_title')
    expect(originalTitle.text()).toBe("Original Title: The Matrix")

    const originalLang = overviewComponent.find('.mmodb-original_language')
    expect(originalLang.text()).toBe("Original Film Language: English (en)")
  })
})
