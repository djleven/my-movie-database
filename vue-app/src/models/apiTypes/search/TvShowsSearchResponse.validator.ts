// @ts-nocheck
// eslint-disable
import Ajv from 'ajv'
import type * as apiTypes from './TvShowsSearchResponse'
import addFormats from 'ajv-formats'

export const SCHEMA = {
    "$schema": "http://json-schema.org/draft-07/schema#",
    "definitions": {
        "TvShowsSearchResponse": {
            "type": "object",
            "properties": {
                "page": {
                    "type": "number"
                },
                "total_results": {
                    "type": "number"
                },
                "total_pages": {
                    "type": "number"
                },
                "results": {
                    "type": "array",
                    "items": {
                        "$ref": "#/definitions/TvShowSearchData"
                    }
                }
            },
            "required": [
                "page",
                "results",
                "total_pages",
                "total_results"
            ],
            "additionalProperties": false
        },
        "BaseSearchResponse": {
            "type": "object",
            "properties": {
                "page": {
                    "type": "number"
                },
                "total_results": {
                    "type": "number"
                },
                "total_pages": {
                    "type": "number"
                }
            },
            "required": [
                "page",
                "total_results",
                "total_pages"
            ],
            "additionalProperties": false
        },
        "TvShowSearchData": {
            "type": "object",
            "properties": {
                "poster_path": {
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
                "id": {
                    "type": "number"
                },
                "backdrop_path": {
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
                "original_language": {
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
                "name": {
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
        }
    }
}

const ajv = new Ajv({ removeAdditional: true }).addSchema(SCHEMA, "SCHEMA")
addFormats(ajv)
export function validateTvShowsSearchResponse(payload: unknown): apiTypes.TvShowsSearchResponse {
    /** Schema is defined in {@link SCHEMA.definitions.TvShowsSearchResponse } **/
    const validator = ajv.getSchema("SCHEMA#/definitions/TvShowsSearchResponse")
    const valid = validator(payload)
    if (!valid) {
        const error = new Error('Invalid TvShowsSearchResponse: ' + ajv.errorsText(validator.errors, {dataVar: "TvShowsSearchResponse"}));
        error.name = "ValidationError"
        throw error
    }
    return payload
}

export function isTvShowsSearchResponse(payload: unknown): payload is apiTypes.TvShowsSearchResponse {
    try {
        validateTvShowsSearchResponse(payload)
        return true
    } catch (error) {
        return false
    }
}
