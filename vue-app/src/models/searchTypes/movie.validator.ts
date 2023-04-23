// @ts-nocheck
// eslint-disable
import Ajv from 'ajv'
import type * as apiTypes from './movie'
import addFormats from 'ajv-formats'

export const SCHEMA = {
    "$schema": "http://json-schema.org/draft-07/schema#",
    "definitions": {
        "MoviesSearchResponse": {
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
                        "$ref": "#/definitions/MovieSearchData"
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
        "MovieSearchData": {
            "type": "object",
            "properties": {
                "poster_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "adult": {
                    "type": "boolean"
                },
                "overview": {
                    "type": "string"
                },
                "release_date": {
                    "type": "string",
                    "oneOf": [
                        {
                            "maxLength": 0
                        },
                        {
                            "format": 'date',
                            "minLength": 1
                        }
                    ],
                },
                "genre_ids": {
                    "type": "array",
                    "items": {
                        "type": "number"
                    }
                },
                "id": {
                    "type": "number"
                },
                "original_language": {
                    "type": "string"
                },
                "original_title": {
                    "type": "string"
                },
                "title": {
                    "type": "string"
                },
                "backdrop_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "popularity": {
                    "type": "number"
                },
                "vote_average": {
                    "type": "number"
                },
                "vote_count": {
                    "type": "number"
                },
                "video": {
                    "type": "boolean"
                }
            },
            "required": [
                "id"
            ],
            "additionalProperties": false
        }
    }
};
const ajv = new Ajv({ removeAdditional: true }).addSchema(SCHEMA, "SCHEMA");
addFormats(ajv)
export function validateMoviesSearchResponse(payload: unknown): apiTypes.MoviesSearchResponse {
  /** Schema is defined in {@link SCHEMA.definitions.MoviesSearchResponse } **/
  const validator = ajv.getSchema("SCHEMA#/definitions/MoviesSearchResponse");
  const valid = validator(payload);
  if (!valid) {
    const error = new Error('Invalid MoviesSearchResponse: ' + ajv.errorsText(validator.errors, {dataVar: "MoviesSearchResponse"}));
    error.name = "ValidationError";
    throw error;
  }
  return payload;
}

export function isMoviesSearchResponse(payload: unknown): payload is apiTypes.MoviesSearchResponse {
  try {
    validateMoviesSearchResponse(payload);
    return true;
  } catch (error) {
    return false;
  }
}
