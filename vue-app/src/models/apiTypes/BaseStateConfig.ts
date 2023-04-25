import {
    ContentTypes,
    GlobalSettings,
    SectionShowSettings,
    Templates,
    TypeStylingSettings
} from "@/models/settings";

export default interface BaseStateConfig {
    id: number
    type: ContentTypes
    template: Templates
    global_conf: GlobalSettings
    showSettings: SectionShowSettings
    styling: TypeStylingSettings
}