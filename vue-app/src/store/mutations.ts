import {BaseTemplateSections, ContentId} from "@/models/settings";

export default {
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
    setContentLoaded(state, status: boolean) {
        state.contentLoaded = status
    },
    setContentLoading(state,  status: boolean) {
        state.contentLoading = status
    },
}
