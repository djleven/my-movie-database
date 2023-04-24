import {
    ContentId,
    ContentTypes,
    GlobalSettings,
    SectionShowSettings,
    Templates,
    TypeStylingSettings
} from "@/models/settings";

export default interface BaseStateConfig {
    id: ContentId
    type: ContentTypes
    template: Templates
    global_conf: GlobalSettings
    showSettings: SectionShowSettings
    styling: TypeStylingSettings
}