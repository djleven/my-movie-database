// @ts-nocheck
// eslint-disable
import Ajv from 'ajv';
import type * as apiTypes from './BaseStateConfig'
import addFormats from 'ajv-formats'

export const SCHEMA = {
    "$schema": "http://json-schema.org/draft-07/schema#",
    "$ref": "#/definitions/BaseStateConfig",
    "definitions": {
        "BaseStateConfig": {
            "type": "object",
            "properties": {
                "id": {
                    "oneOf": [
                        {
                            "type": "integer",
                            "minimum": 1
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "type": {
                    "$ref": "#/definitions/ContentTypes"
                },
                "template": {
                    "$ref": "#/definitions/Templates"
                },
                "global_conf": {
                    "$ref": "#/definitions/GlobalSettings"
                },
                "showSettings": {
                    "$ref": "#/definitions/SectionShowSettings"
                },
                "styling": {
                    "$ref": "#/definitions/TypeStylingSettings"
                }
            },
            "required": [
                "id",
                "type",
                "template",
                "global_conf",
                "showSettings",
                "styling"
            ],
            "additionalProperties": false
        },
        "ContentTypes": {
            "type": "string",
            "enum": [
                "tvshow",
                "movie",
                "person"
            ]
        },
        "Templates": {
            "type": "string",
            "enum": [
                "accordion",
                "tabs"
            ]
        },
        "GlobalSettings": {
            "type": "object",
            "properties": {
                "locale": {
                    "type": "string"
                },
                "debug": {
                    "type": "boolean"
                },
                "date_format": {
                    "type": "string"
                },
                "overviewOnHover": {
                    "type": "boolean"
                }
            },
            "required": [
                "locale",
                "debug",
                "date_format",
                "overviewOnHover"
            ],
            "additionalProperties": false
        },
        "Color": {
            "type": "string"
        },
        "SectionShowSettings": {
            "type": "object",
            "properties": {
                "overview_text": {
                    "type": "boolean"
                },
                "section_2": {
                    "type": "boolean"
                },
                "section_3": {
                    "type": "boolean"
                },
                "section_4": {
                    "type": "boolean"
                }
            },
            "required": [
                "overview_text",
                "section_2",
                "section_3",
                "section_4"
            ],
            "additionalProperties": false
        },
        "TypeStylingSettings": {
            "type": "object",
            "properties": {
                "size": {
                    "$ref": "#/definitions/Sizes"
                },
                "headerColor": {
                    "$ref": "#/definitions/Color"
                },
                "bodyColor": {
                    "$ref": "#/definitions/Color"
                },
                "headerFontColor": {
                    "$ref": "#/definitions/Color"
                },
                "bodyFontColor": {
                    "$ref": "#/definitions/Color"
                },
                "transitionEffect": {
                    "$ref": "#/definitions/TransitionEffects"
                }
            },
            "required": [
                "size",
                "headerColor",
                "bodyColor",
                "headerFontColor",
                "bodyFontColor",
                "transitionEffect"
            ],
            "additionalProperties": false
        },
        "Sizes": {
            "type": "string",
            "enum": [
                "small",
                "medium",
                "large"
            ]
        },
        "TransitionEffects": {
            "type": "string",
            "enum": [
                "fade",
                "bounce",
                "none"
            ]
        }
    }
}

const ajv = new Ajv({ removeAdditional: true }).addSchema(SCHEMA, "SCHEMA")
addFormats(ajv)
export function validateBaseStateConfig(payload: unknown): apiTypes.BaseStateConfig {
    /** Schema is defined in {@link SCHEMA.definitions.BaseStateConfig } **/
    const validator = ajv.getSchema("SCHEMA#/definitions/BaseStateConfig")
    const valid = validator(payload)
    if (!valid) {
        const error = new Error(`Invalid mmdb configuration for ${payload.type} type with id of ${payload.id}: ` + createErrorMsg(validator.errors))
        error.name = "ValidationError"
        throw error
    }
    return payload
}

export function isBaseStateConfig(payload: unknown): payload is apiTypes.BaseStateConfig {
    try {
        validateBaseStateConfig(payload)
        return true
    } catch (error) {
        return false
    }
}

function createErrorMsg(errors: array): string {
    let extra = ''
    const error = errors[0]
    const field = error.instancePath.substring(error.instancePath.lastIndexOf('/') + 1)
    if(error.keyword === 'enum') {
        extra = `Allowed values are: ${error.params.allowedValues.join(', ')}`
    }

    return `${field} ${error.message}. ${extra}`
}


