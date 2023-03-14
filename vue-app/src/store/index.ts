import Movie from '@/models/contentTypes/movie'
import Tvshow from '@/models/contentTypes/tvshow'
import Person from '@/models/contentTypes/person'
import { ContentId, ContentTypes, Templates, GlobalSettings, SectionShowSettings, TypeStylingSettings, PlaceholderURLs, BaseTemplateSections } from '@/models/settings'

const mutations = {
    addContent(state, payload: any) {
        state.content = payload
    },
    addCredits(state, payload: any) {
        state.credits = payload
    },
    setActive(state, activeTab: BaseTemplateSections) {
        state.activeTab = activeTab
    },
    setID(state, id: ContentId) {
        state.id = id
    },
}

const actions = {
}

interface BaseStateInterface {
    id: ContentId
    type: ContentTypes
    template: Templates
    global_conf: GlobalSettings
    showSettings: SectionShowSettings
    cssClasses: TypeStylingSettings
    placeholder: PlaceholderURLs
}

interface SectionComponentsInterface {
    [BaseTemplateSections.Overview]: string
    [BaseTemplateSections.Section_2]: string
    [BaseTemplateSections.Section_3]: string
    [BaseTemplateSections.Section_4]: string
}

interface StateInterface extends BaseStateInterface {
    content?: any,
    credits?: any,
    activeTab: BaseTemplateSections,
    components: SectionComponentsInterface,
    __t: any,
}

const initiateStore = (conf: BaseStateInterface, i18n: any): { state: StateInterface, actions: any, mutations: any } => {
    const type = conf.type
    let object
    if(type === ContentTypes.Movie) {
       object = new Movie()
    }else if(type === ContentTypes.TvShow) {
        object =  new Tvshow()
    }else if(type === ContentTypes.Person) {
        object =  new Person()
    }

    const myState: StateInterface = Object.assign({
        content: null,
        credits: null,
        components: object.components,
        activeTab: BaseTemplateSections.Overview,
        __t: i18n
    }, conf)

    return {
        state: myState,
        actions,
        mutations
    }
}

export default initiateStore