import { InjectionKey } from 'vue'
import { createStore, Store, useStore as baseUseStore } from 'vuex'

import getters from './getters'
import actions from './actions'
import mutations from './mutations'
import tvModule, { TvShowState } from '@/store/tv'
import movieModule, { MovieState } from '@/store/movie'
import personModule, { PersonState }  from '@/store/person'

import Movie from '@/models/contentTypes/movie'
import Tvshow from '@/models/contentTypes/tvshow'
import Person from '@/models/contentTypes/person'
import BaseStateConfig from '@/models/apiTypes/BaseStateConfig'
import { ContentTypes, BaseTemplateSections } from '@/models/settings'


interface SectionComponents {
    [BaseTemplateSections.Overview]: string
    [BaseTemplateSections.Section_2]: string
    [BaseTemplateSections.Section_3]: string
    [BaseTemplateSections.Section_4]: string
}

export interface AppState extends BaseStateConfig {
    error: string,
    contentLoaded: boolean,
    contentLoading: boolean,
    activeSection: BaseTemplateSections,
    components: SectionComponents,
    movie?: MovieState,
    tvshow?: TvShowState,
    person?: PersonState
}

export const key: InjectionKey<Store<AppState>> = Symbol()

export const initiateStore = (conf: BaseStateConfig): Store<AppState> => {
    const type = conf.type
    let object
    if(type === ContentTypes.Movie) {
       object = new Movie()
    } else if(type === ContentTypes.TvShow) {
        object =  new Tvshow()
    } else if(type === ContentTypes.Person) {
        object =  new Person()
    }

    const moduleInitialState: MovieState | TvShowState | PersonState = object.getInitialState()
    const moduleState = {
        [type]: moduleInitialState
    }

    const myState: AppState = Object.assign({
        error: '',
        contentLoaded: false,
        contentLoading: false,
        components: object.components,
        activeSection: BaseTemplateSections.Overview,
    }, moduleState, conf)

    return createStore<AppState>({
        modules: {
            tvshow: tvModule,
            movie: movieModule,
            person: personModule
        },
        state: myState,
        actions,
        getters,
        mutations
    })
}

export function useStore () {
    return baseUseStore(key)
}