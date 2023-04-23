// @ts-nocheck
// eslint-disable
import Ajv from 'ajv'
import type * as apiTypes from './MovieData'
import addFormats from 'ajv-formats'

export const SCHEMA = {
    "$schema": "http://json-schema.org/draft-07/schema#",
    "$ref": "#/definitions/MovieData",
    "definitions": {
        "MovieData": {
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
                "belongs_to_collection": {
                    "anyOf": [
                        {
                            "type": "object",
                            "properties": {
                                "backdrop_path": {
                                    "type": [
                                        "string",
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
                                "poster_path": {
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
                        },
                        {
                            "type": "null"
                        }
                    ]
                },
                "budget": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "imdb_id": {
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
                "revenue": {
                    "type": [
                        "number",
                        "null"
                    ]
                },
                "runtime": {
                    "type": [
                        "number",
                        "null"
                    ]
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
                "title": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "trailers": {
                    "type": "object",
                    "properties": {
                        "youtube": {
                            "type": "array",
                            "items": {
                                "type": "object",
                                "properties": {
                                    "name": {
                                        "type": [
                                            "string",
                                            "null"
                                        ]
                                    },
                                    "size": {
                                        "type": [
                                            "string",
                                            "null"
                                        ]
                                    },
                                    "source": {
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
                                "additionalProperties": false
                            }
                        }
                    },
                    "additionalProperties": false
                },
                "video": {
                    "type": [
                        "boolean",
                        "null"
                    ]
                }
            },
            "required": [
                "id",
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
                "id",
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
                "id",
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
                "id",
            ],
            "additionalProperties": false
        }
    }
}

const ajv = new Ajv({ removeAdditional: true }).addSchema(SCHEMA, "SCHEMA")
addFormats(ajv)
export function validateMovieData(payload: unknown): apiTypes.MovieData {
    /** Schema is defined in {@link SCHEMA.definitions.MovieData } **/
    const validator = ajv.getSchema("SCHEMA#/definitions/MovieData")
    const valid = validator(payload)
    if (!valid) {
        const error = new Error('Invalid MovieData: ' + ajv.errorsText(validator.errors, {dataVar: "MovieData"}))
        error.name = "ValidationError"
        throw error
    }
    return payload
}

export function isMovieData(payload: unknown): payload is apiTypes.MovieData {
    try {
        validateMovieData(payload)
        return true
    } catch (error) {
        return false
    }
}

