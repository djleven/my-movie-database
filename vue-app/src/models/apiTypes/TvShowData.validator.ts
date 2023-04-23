// @ts-nocheck
// eslint-disable
import Ajv from 'ajv'
import type * as apiTypes from './TvShowData'
import addFormats from 'ajv-formats'
export const SCHEMA = {
    "$schema": "http://json-schema.org/draft-07/schema#",
    "$ref": "#/definitions/TvShowData",
    "definitions": {
        "TvShowData": {
            "type": "object",
            "properties": {
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
                "credits": {
                    "$ref": "#/definitions/ScreenPlayCredits"
                },
                "genres": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "properties": {
                            "id": {
                                "type": "number"
                            },
                            "name": {
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
                "original_language": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "overview": {
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
                "poster_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "production_companies": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/ProductionCompany"
                    }
                },
                "production_countries": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "properties": {
                            "iso_3166_1": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            },
                            "name": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            }
                        },
                        "additionalProperties": false
                    }
                },
                "spoken_languages": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "properties": {
                            "english_name": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            },
                            "iso_639_1": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            },
                            "name": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            }
                        },
                        "additionalProperties": false
                    }
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
                "created_by": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "properties": {
                            "credit_id": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            },
                            "gender": {
                                "type": "number",
                                "enum": [
                                    1,
                                    2
                                ]
                            },
                            "id": {
                                "type": "number"
                            },
                            "name": {
                                "type": [
                                    "string",
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
                            "id",
                        ],
                        "additionalProperties": false
                    }
                },
                "episode_run_time": {
                    "type": "array",
                    "items": {
                        "type": "number"
                    }
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
                "in_production": {
                    "type": [
                        "boolean",
                        "null"
                    ]
                },
                "languages": {
                    "type": "array",
                    "items": {
                        "type": "string"
                    }
                },
                "last_air_date": {
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
                "last_episode_to_air": {
                    "anyOf": [
                        {
                            "type": "object",
                            "properties": {
                                "air_date": {
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
                                "episode_number": {
                                    "type": [
                                        "number",
                                        "null"
                                    ]
                                },
                                "id": {
                                    "type": "number"
                                },
                                "name": {
                                    "type": [
                                        "string",
                                        "null"
                                    ]
                                },
                                "overview": {
                                    "type": [
                                        "string",
                                        "null"
                                    ]
                                },
                                "production_code": {
                                    "type": [
                                        "string",
                                        "null"
                                    ]
                                },
                                "season_number": {
                                    "type": [
                                        "number",
                                        "null"
                                    ]
                                },
                                "still_path": {
                                    "type": [
                                        "string",
                                        "null"
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
                                }
                            },
                            "required": [
                                "id"
                            ],
                            "additionalProperties": false
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "networks": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/ProductionCompany"
                    }
                },
                "next_episode_to_air": {
                    "anyOf": [
                        {
                            "type": "object",
                            "properties": {
                                "air_date": {
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
                                "episode_number": {
                                    "type": [
                                        "number",
                                        "null"
                                    ]
                                },
                                "id": {
                                    "type": "number"
                                },
                                "name": {
                                    "type": [
                                        "string",
                                        "null"
                                    ]
                                },
                                "overview": {
                                    "type": [
                                        "string",
                                        "null"
                                    ]
                                },
                                "production_code": {
                                    "type": [
                                        "string",
                                        "null"
                                    ]
                                },
                                "season_number": {
                                    "type": [
                                        "number",
                                        "null"
                                    ]
                                },
                                "still_path": {
                                    "type": [
                                        "string",
                                        "null"
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
                                }
                            },
                            "required": [
                                "id"
                            ],
                            "additionalProperties": false
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "number_of_episodes": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "number_of_seasons": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "origin_country": {
                    "type": "array",
                    "items": {
                        "type": "string"
                    }
                },
                "original_name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "seasons": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "properties": {
                            "air_date": {
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
                            "episode_count": {
                                "type": [
                                    "number",
                                    "null"
                                ]
                            },
                            "id": {
                                "type": "number"
                            },
                            "name": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            },
                            "overview": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            },
                            "poster_path": {
                                "type": [
                                    "string",
                                    "null"
                                ]
                            },
                            "season_number": {
                                "type": [
                                    "number",
                                    "null"
                                ]
                            }
                        },
                        "required": [
                            "id"
                        ],
                        "additionalProperties": false
                    }
                },
                "status": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "tagline": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "type": {
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
        "ScreenPlayCredits": {
            "type": "object",
            "properties": {
                "cast": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/ScreenPlayCastCredit"
                    }
                },
                "crew": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/ScreenPlayCrewCredit"
                    }
                }
            },
            "required": [
                "cast",
                "crew"
            ],
            "additionalProperties": false
        },
        "ScreenPlayCastCredit": {
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
                "gender": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "known_for_department": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "profile_path": {
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
                },
                "order": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "cast_id": {
                    "type": [
                        "number",
                        "null"
                    ]
                }
            },
            "required": [
                "id"
            ],
            "additionalProperties": false
        },
        "ScreenPlayCrewCredit": {
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
                    "type": "number"
                },
                "gender": {
                    "type": "number"
                },
                "known_for_department": {
                    "type": "string"
                },
                "profile_path": {
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
        },
        "ProductionCompany": {
            "type": "object",
            "properties": {
                "id": {
                    "type": "number"
                },
                "logo_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "name": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "origin_country": {
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
export function validateTvShowData(payload: unknown): apiTypes.TvShowData {
    /** Schema is defined in {@link SCHEMA.definitions.TvShowData } **/
    const validator = ajv.getSchema("SCHEMA#/definitions/TvShowData")
    const valid = validator(payload)
    if (!valid) {
        const error = new Error('Invalid TvShowData: ' + ajv.errorsText(validator.errors, {dataVar: "TvShowData"}))
        error.name = "ValidationError"
        throw error
    }
    return payload
}

export function isTvShowData(payload: unknown): payload is apiTypes.TvShowData {
    try {
        validateTvShowData(payload)
        return true
    } catch (error) {
        return false
    }
}


