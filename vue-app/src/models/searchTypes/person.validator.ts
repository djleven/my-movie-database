// @ts-nocheck
// eslint-disable
import Ajv from 'ajv'
import type * as apiTypes from './person'
import addFormats from 'ajv-formats'

export const SCHEMA = {
    "$schema": "http://json-schema.org/draft-07/schema#",
    "definitions": {
        "PeopleSearchResponse": {
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
                        "$ref": "#/definitions/PersonSearchData"
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
        "PersonSearchData": {
            "type": "object",
            "properties": {
                "profile_path": {
                    "type": [
                        "string",
                        "null"
                    ]
                },
                "adult": {
                    "type": "boolean"
                },
                "id": {
                    "type": "number"
                },
                "name": {
                    "type": "string"
                },
                "popularity": {
                    "type": "number"
                },
                "known_for": {
                    "anyOf": [
                        {
                            "type": "array",
                            "items": {
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
                                    },
                                    "media_type": {
                                        "type": "string",
                                    }
                                },
                                "required": [
                                    "id",
                                    "media_type"
                                ],
                                "additionalProperties": false
                            }
                        },
                        {
                            "type": "array",
                            "items": {
                                "type": "object",
                                "properties": {
                                    "poster_path": {
                                        "type": [
                                            "string",
                                            "null"
                                        ]
                                    },
                                    "popularity": {
                                        "type": "number"
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
                                        "type": "string"
                                    },
                                    "first_air_date": {
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
                                        "type": "string"
                                    },
                                    "original_name": {
                                        "type": "string"
                                    },
                                    "title": {
                                        "type": "string"
                                    },
                                    "vote_average": {
                                        "type": "number"
                                    },
                                    "vote_count": {
                                        "type": "number"
                                    },
                                    "media_type": {
                                        "type": "string",
                                    }
                                },
                                "required": [
                                    "id",
                                    "media_type"
                                ],
                                "additionalProperties": false
                            }
                        }
                    ]
                }
            },
            "required": [
                "id"
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
                    "type": "number"
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
                    "type": "string"
                },
                "first_air_date": {
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
                    "type": "string"
                },
                "original_name": {
                    "type": "string"
                },
                "title": {
                    "type": "string"
                },
                "vote_average": {
                    "type": "number"
                },
                "vote_count": {
                    "type": "number"
                }
            },
            "required": [
                "id",
            ],
            "additionalProperties": false
        }
    }
};
const ajv = new Ajv({ removeAdditional: true }).addSchema(SCHEMA, "SCHEMA");
addFormats(ajv)
export function validatePeopleSearchResponse(payload: unknown): apiTypes.PeopleSearchResponse {
  /** Schema is defined in {@link SCHEMA.definitions.PeopleSearchResponse } **/
  const validator = ajv.getSchema("SCHEMA#/definitions/PeopleSearchResponse");
  const valid = validator(payload);
  if (!valid) {
    const error = new Error('Invalid PeopleSearchResponse: ' + ajv.errorsText(validator.errors, {dataVar: "PeopleSearchResponse"}));
    error.name = "ValidationError";
    throw error;
  }
  return payload;
}

export function isPeopleSearchResponse(payload: unknown): payload is apiTypes.PeopleSearchResponse {
  try {
    validatePeopleSearchResponse(payload);
    return true;
  } catch (error) {
    return false;
  }
}
