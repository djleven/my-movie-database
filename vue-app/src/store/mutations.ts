import { BaseTemplateSections, ContentId } from '@/models/settings'

export default {
    setActiveSection(state, activeSection?: BaseTemplateSections) {
        if(!activeSection) {
            activeSection = BaseTemplateSections.Overview
        }
        state.activeSection = activeSection
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
    setErrorMessage(state,  msg: string) {
        state.error = msg
    },
}
