import {BaseTemplateSections} from "@/models/settings";

export type SectionTemplates  = {
    [key in BaseTemplateSections]: {
        showIf: boolean,
        title: string,
        componentName: string,
    }
}
