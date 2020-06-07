/*
 * Adapted from https://github.com/cavestri/themoviedb-javascript-library
 * The MIT License (MIT)
 * Copyright (c) Franco Cavestri
 */
var theMovieDb = {};

theMovieDb.common = {
    api_key: "c8df48be0b9d3f1ed59ee365855e663a",
    base_uri: "https://api.themoviedb.org/3/",
    images_uri: "https://image.tmdb.org/t/p/",
    timeout: 5000,
    language: mmdb_conf.locale.substring(0,2),
    adult: false,
    debug: mmdb_conf.debug,
    generateQuery: function(options) {
        'use strict';
        var myOptions, query, option;

        myOptions = options || {};
        query = "?api_key=" + theMovieDb.common.api_key + "&language=" + theMovieDb.common.language;

        if (Object.keys(myOptions).length > 0) {
            for (option in myOptions) {
                if (myOptions.hasOwnProperty(option) && option !== "id" && option !== "body") {
                    query = query + "&" + option + "=" + myOptions[option];
                }
            }
        }

        return query;
    },
    validateRequired: function(args, argsReq) {
        'use strict';
        if (args.length !== argsReq) {
            throw "The method requires  " + argsReq + " arguments and you are sending " + args.length + "!";
        }

    },
    getImage: function(options) {
        'use strict';
        return theMovieDb.common.images_uri + options.size + "/" + options.file;
    },
    client: function(options) {
        'use strict';
        let data = null;
        let method = options.method || "GET";
        // let status = options.status || 200;
        let headers = {};

        if (method === "POST") {
            headers = {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
            data = JSON.stringify(options.body);
        }

        return jQuery.ajax({
            url: theMovieDb.common.base_uri + options.url,
            type: method,
            data: data,
            headers: headers,
            timeout: theMovieDb.common.timeout,
            datatype: 'json'
        })
            .done(function (data) {
                return data;
            })
            .fail(function (jqXHR, textStatus) {
                if(textStatus === 'error') {
                    console.log('Failed fetching data from TMDB')
                }
                console.log(jqXHR)
            })
    }
};

theMovieDb.helpers = {
    getTitleWithYear: function (title, date) {
        const year = new Date(date).getFullYear()
        if(year) {
            return `${title} (${year})`
        }
        return title
    },
    getPropertyAsCsvFromObjectArray: function (objArray, prop = 'name') {
        if(Array.isArray(objArray)) {
            objArray = objArray.map(function(x) {
                return x[prop]
            })

            return objArray.join(', ')
        }
    },
    getExcerpt: function (text, maxLen) {
        if(text.length > maxLen) {
            return `${this.tidyExcerpt(text, maxLen)} ...`
        }

        return text
    },
    tidyExcerpt: function (text, maxLen, separator = ' ') {
        if (text.length <= maxLen) {
            return text;
        }
        return text.substr(0, text.lastIndexOf(separator, maxLen));
    },
    filterCreditsByMediaType: function (credits, filter) {
        return credits.filter(function (credit) {
                if(credit.media_type  === filter) {
                    return credit
                }
            });
    },
    processCreditsPayload: function(data, type) {
        if(type === 'person') {
            data = {
                cast: {
                    movie: this.orderCredits(
                        this.filterCreditsByMediaType(data.cast, 'movie'),
                        'release_date',
                        true
                    ),
                    tv: this.orderCredits(
                        this.filterCreditsByMediaType(data.cast, 'tv'),
                        'episode_count'
                    )
                },
                crew: {
                    movie: this.orderCredits(
                        this.filterCreditsByMediaType(data.crew, 'movie'),
                        'release_date',
                        true
                    ),
                    tv: this.orderCredits(
                        this.filterCreditsByMediaType(data.crew, 'tv'),
                        'episode_count'
                    )
                }
            }
        } else {
            data.cast = this.orderCredits(data.cast, 'order', false, false)
        }
        return data
    },
    formatDate: function (date) {
        const format = mmdb_conf.date_format
        let locale = theMovieDb.common.language
        let month = 'numeric';
        if(!date) {
            return null
        }
        if(format === 'Y-m-d') {
            locale = 'en-CA'
        } else if(format === 'd/m/Y') {
            locale ='fr-FR'
        } else if(format === 'm/d/Y') {
            locale ='en-US'
        } else {
            month = 'long';
        }
        return new Date(date).toLocaleDateString(
            locale,
            {
                day: '2-digit',
                month: month,
                year: 'numeric',
                timeZone: 'UTC',
            }
        );
    },
    orderCredits: function (credits, comparison, date = false, desc = true) {
        if(Array.isArray(credits) && credits.length) {
            if(date) {
                const unixReleaseDate = 'unixReleaseDate'
                credits.map(function (credit) {
                    credit[unixReleaseDate] = + new Date(credit[comparison])
                })
                comparison = unixReleaseDate
            }
            return credits.sort(function (a, b) {
                if(desc) {
                    return b[comparison] - a[comparison];
                } else {
                    return a[comparison] - b[comparison];
                }
            });
        }

        return credits
    },
    getImage: function (file, size) {
        if(size === 'small'){
            size = 'w132_and_h132_bestv2'
        } else if(size === 'medium'){
            size = 'w185'
        } else if(size === 'large'){
            size = 'w300'
        }
        return theMovieDb.common.getImage({size, file})
    }
};

theMovieDb.movie = {
    getById: function(options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["id"]);
        return theMovieDb.common.client({
            url: "movie/" + options.id + theMovieDb.common.generateQuery(options) + '&append_to_response=trailers'
        });
    },
    getCredits: function(options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["id"]);
        return theMovieDb.common.client({
            url: "movie/" + options.id + "/credits" + theMovieDb.common.generateQuery(options)
        });
    }
};

theMovieDb.person = {
    getById: function (options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["id"]);
        return theMovieDb.common.client({
            url: "person/" + options.id + theMovieDb.common.generateQuery(options)
        });
    },
    getCredits: function (options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["id"]);
        return theMovieDb.common.client({
            url: "person/" + options.id + "/combined_credits" + theMovieDb.common.generateQuery(options)
        });
    },
};

theMovieDb.search = {
    movie: function(options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["query"]);
        return theMovieDb.common.client({
            url: "search/movie" + theMovieDb.common.generateQuery(options)
        });
    },
    tvshow: function(options) {
        'use strict';
        theMovieDb.common.validateRequired(arguments, 1, options, ["query"]);
        return theMovieDb.common.client({
            url: "search/tv" + theMovieDb.common.generateQuery(options)
        });
    },
    person: function(options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["query"]);
        return theMovieDb.common.client({
            url: "search/person" + theMovieDb.common.generateQuery(options)
        });
    }
};

theMovieDb.tvshow = {
    getById: function(options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["id"]);
        return theMovieDb.common.client({
            url: "tv/" + options.id + theMovieDb.common.generateQuery(options)
        });
    },
    getCredits: function(options) {
        'use strict';

        theMovieDb.common.validateRequired(arguments, 1, options, ["id"]);
        return theMovieDb.common.client({
            url: "tv/" + options.id + "/credits" + theMovieDb.common.generateQuery(options)
        });
    }
};