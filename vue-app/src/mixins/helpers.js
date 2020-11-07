const helpers = {
    getTitleWithYear(title, date) {
        const year = new Date(date).getFullYear()
        if(year) {
            return `${title} (${year})`
        }
        return title
    },
    getPropertyAsCsvFromObjectArray(objArray, prop = 'name') {
        if(Array.isArray(objArray)) {
            objArray = objArray.map((x) => {
                return x[prop]
            })

            return objArray.join(', ')
        }
    },
    getExcerpt(text, maxLen) {
        if(text.length > maxLen) {
            return `${this.tidyExcerpt(text, maxLen)} ...`
        }

        return text
    },
    tidyExcerpt(text, maxLen, separator = ' ') {
        if (text.length <= maxLen) {
            return text;
        }
        return text.substr(0, text.lastIndexOf(separator, maxLen));
    },
    filterCreditsByMediaType(credits, filter) {
        return credits.filter((credit) => {
                if(credit.media_type  === filter) {
                    return credit
                }
            });
    },
    processCreditsPayload(data) {
        if(this.$store.state.type === 'person') {
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
    formatDate(date) {
        const format = this.$store.state.global_conf.date_format
        let locale = this.$store.state.global_conf.locale.substring(0,2)
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
    orderCredits(credits, comparison, date = false, desc = true) {
        if(Array.isArray(credits) && credits.length) {
            if(date) {
                const unixReleaseDate = 'unixReleaseDate'
                credits.map((credit) => {
                    credit[unixReleaseDate] = + new Date(credit[comparison])
                })
                comparison = unixReleaseDate
            }
            return credits.sort((a, b) => {
                if(desc) {
                    return b[comparison] - a[comparison];
                } else {
                    return a[comparison] - b[comparison];
                }
            });
        }

        return credits
    },
    getImageUrl(file, size) {
        const images_uri = "https://image.tmdb.org/t/p/"
        if(size === 'small'){
            size = 'w132_and_h132_bestv2'
        } else if(size === 'medium'){
            size = 'w185'
        } else if(size === 'large'){
            size = 'w300'
        }
        return images_uri + size + "/" + file;
    },
}


export default {
    methods: helpers
}