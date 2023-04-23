// @ts-nocheck
// eslint-disable
import Ajv from 'ajv'
import type * as apiTypes from './PersonData'
import addFormats from 'ajv-formats'

export const SCHEMA = {
    "$schema": "http://json-schema.org/draft-07/schema#",
    "$ref": "#/definitions/PersonData",
    "definitions": {
        "PersonData": {
            "type": "object",
            "properties": {
                "name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "adult": {
                    "type": [
                        "boolean",
                        "null"
                    ]
                },
                "backdrop_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "known_for_department": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "also_known_as": {
                    "type": "array",
                    "items": {
                        "type": [
                            "string",
                            "null"
                        ]
                    }
                },
                "birthday": {
                    "anyOf": [
                        {
                            "type": "string",
                            "oneOf": [
                                {
                                    "maxLength": 0
                                },
                                {
                                    "format": "date"
                                }
                            ],
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "place_of_birth": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "combined_credits": {
                    "$ref": "#/definitions/PersonCredits"
                },
                "deathday": {
                    "anyOf": [
                        {
                            "type": "string",
                            "oneOf": [
                                {
                                    "maxLength": 0
                                },
                                {
                                    "format": "date"
                                }
                            ],
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "gender": {
                    "type": "number",
                    "enum": [
                        0,
                        1,
                        2,
                        3
                    ]
                },
                "homepage": {
                    "anyOf": [
                        {
                            "type": "string",
                            "format": "uri"
                        },
                        {
                            "type": "null"
                        },
                        {
                            "type": "string",
                            "maxLength": 0
                        }
                    ]
                },
                "id": {
                    "type": "number"
                },
                "imdb_id": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "biography": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "popularity": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "profile_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                }
            },
            "required": [
                "id"
            ],
            "additionalProperties": false
        },
        "PersonCredits": {
            "type": "object",
            "properties": {
                "cast": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/PersonCastCredit"
                    }
                },
                "crew": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/PersonCrewCredit"
                    }
                }
            },
            "required": [
                "cast",
                "crew"
            ],
            "additionalProperties": false
        },
        "PersonCastCredit": {
            "type": "object",
            "properties": {
                "credit_id": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "id": {
                    "type": "number"
                },
                "adult": {
                    "type": [
                        "boolean",
                        "null"
                    ]
                },
                "name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "original_name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "popularity": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "original_language": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "episode_count": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "overview": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "origin_country": {
                    "type": "array",
                    "items": {
                        "type": "string"
                    }
                },
                "genre_ids": {
                    "type": "array",
                    "items": {
                        "type": "number"
                    }
                },
                "media_type": {
                    "type": "string"
                },
                "poster_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "first_air_date": {
                    "anyOf": [
                        {
                            "type": "string",
                            "oneOf": [
                                {
                                    "maxLength": 0
                                },
                                {
                                    "format": "date"
                                }
                            ],
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "vote_average": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "vote_count": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "backdrop_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "original_title": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "video": {
                    "type": [
                        "boolean",
                        "null"
                    ]
                },
                "release_date": {
                    "anyOf": [
                        {
                            "type": "string",
                            "oneOf": [
                                {
                                    "maxLength": 0
                                },
                                {
                                    "format": "date"
                                }
                            ],
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "title": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "character": {
                    "type": [
                        "string",
                        "null"
                    ]
                }
            },
            "required": [
                "id"
            ],
            "additionalProperties": false
        },
        "PersonCrewCredit": {
            "type": "object",
            "properties": {
                "credit_id": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "id": {
                    "type": "number"
                },
                "adult": {
                    "type": [
                        "boolean",
                        "null"
                    ]
                },
                "name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "original_name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "popularity": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "original_language": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "episode_count": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "overview": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "origin_country": {
                    "type": "array",
                    "items": {
                        "type": "string"
                    }
                },
                "genre_ids": {
                    "type": "array",
                    "items": {
                        "type": "number"
                    }
                },
                "media_type": {
                    "type": "string"
                },
                "poster_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "first_air_date": {
                    "anyOf": [
                        {
                            "type": "string",
                            "oneOf": [
                                {
                                    "maxLength": 0
                                },
                                {
                                    "format": "date"
                                }
                            ],
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "vote_average": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "vote_count": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "backdrop_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "original_title": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "video": {
                    "type": [
                        "boolean",
                        "null"
                    ]
                },
                "release_date": {
                    "anyOf": [
                        {
                            "type": "string",
                            "oneOf": [
                                {
                                    "maxLength": 0
                                },
                                {
                                    "format": "date"
                                }
                            ],
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "title": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "department": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "job": {
                    "type": [
                        "string",
                        "null"
                    ]
                }
            },
            "required": [
                "id"
            ],
            "additionalProperties": false
        }
    }
}

const ajv = new Ajv({ removeAdditional: true }).addSchema(SCHEMA, "SCHEMA")
addFormats(ajv)
export function validatePersonData(payload: unknown): apiTypes.PersonData {
    /** Schema is defined in {@link SCHEMA.definitions.PersonData } **/
    const validator = ajv.getSchema("SCHEMA#/definitions/PersonData")
    const valid = validator(payload)
    if (!valid) {
        const error = new Error('Invalid PersonData: ' + ajv.errorsText(validator.errors, {dataVar: "PersonData"}))
        error.name = "ValidationError"
        throw error
    }
    return payload
}

export function isPersonData(payload: unknown): payload is apiTypes.PersonData {
    try {
        validatePersonData(payload)
        return true
    } catch (error) {
        return false
    }
}


