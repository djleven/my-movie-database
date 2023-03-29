import AbstractEntity, { EntityComponents } from '@/models/contentTypes/abstract-entity'
import { BaseTemplateSections } from '@/models/settings'
import { AppComponents } from '@/models/templates'
import { ScreenPlayTypes, PersonCreditsByScreenPlayType} from "@/models/credits";
import { PersonState } from '@/store/person'

const TypeComponents: EntityComponents = {
  [BaseTemplateSections.Overview]: AppComponents.PersonOverview,
  [BaseTemplateSections.Section_2]: AppComponents.CastCrew,
  [BaseTemplateSections.Section_3]: AppComponents.CastCrew,
}

const initialCreditsState: PersonCreditsByScreenPlayType = {
  cast: {
    [ScreenPlayTypes.Movie]: [],
    [ScreenPlayTypes.Tv]: [],
  },
  crew: {
    [ScreenPlayTypes.Movie]: [],
    [ScreenPlayTypes.Tv]: [],
  }
}

export default class Person extends AbstractEntity {

  getDefaultComponents(): EntityComponents {
    return TypeComponents
  }

  getInitialState(): PersonState {
    return {
      content: null,
      credits: initialCreditsState
    }
  }
}
