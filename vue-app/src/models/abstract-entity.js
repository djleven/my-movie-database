
export default class AbstractEntity {
    constructor ({
                     components = {},
                     __t = {},
                 } = {}) {
        this.components = {
            ...this.getComponents(),
            ...components
        }
        this.__t = {
            ...this.getTranslations(),
            ...__t
        }
    }

    getComponents(){}
    getTranslations(){}
}