export type ContentId = `${number}`;
export enum ContentTypes {
    TvShow = 'tvshow',
    Movie = 'movie',
    Person = 'person',
}

export enum Templates {
    Accordion = 'accordion',
    Tabs = 'tabs',
}

type RGB = `rgb(${number}, ${number}, ${number})`;
type RGBA = `rgba(${number}, ${number}, ${number}, ${number})`;
type HEX = `#${string}`;

export type Color = RGB | RGBA | HEX;

export enum TransitionEffects {
    Fade = 'fade',
    Bounce = 'bounce',
}

export interface GlobalSettings {
    locale: string
    debug: boolean
    date_format: Color
    overviewOnHover: boolean
}

export interface TypeStylingSettings {
    multipleColumn: string
    twoColumn: string
    headerColor: Color
    bodyColor: Color
    headerFontColor: Color
    bodyFontColor: Color
    transitionEffect: TransitionEffects
}

export enum BaseTemplateSections {
    Overview = 'overview',
    Section_2 = 'section_2',
    Section_3 = 'section_3',
    Section_4 = 'section_4',
}

export interface SectionShowSettings {
    Overview_text: boolean
    [BaseTemplateSections.Section_2]: boolean
    [BaseTemplateSections.Section_3]: boolean
    [BaseTemplateSections.Section_4]: boolean
}
