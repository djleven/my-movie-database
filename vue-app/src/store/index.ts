import { InjectionKey } from 'vue'
import { createStore, Store, useStore as baseUseStore } from 'vuex'

import getters from './getters'
import actions from './actions'
import mutations from './mutations'
import tvModule, { TvShowState } from '@/store/tv'
import movieModule, { MovieState } from '@/store/movie'
import personModule, { PersonState }  from '@/store/person'

import BaseStateConfig from '@/models/apiTypes/BaseStateConfig'
import { BaseTemplateSections } from '@/models/settings'

export interface AppState extends BaseStateConfig {
    error: string,
    contentLoaded: boolean,
    contentLoading: boolean,
    activeSection: BaseTemplateSections,
    movie?: MovieState,
    tvshow?: TvShowState,
    person?: PersonState
}

export const key: InjectionKey<Store<AppState>> = Symbol()

export const initiateStore = (conf: BaseStateConfig): Store<AppState> => {
    const myState: AppState = Object.assign({
        error: '',
        contentLoaded: false,
        contentLoading: false,
        activeSection: BaseTemplateSections.Overview,
    }, conf)

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