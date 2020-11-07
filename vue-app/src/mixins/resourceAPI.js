const methods = {
    generateQuery(options) {
        let query = null
        if (Object.keys(options).length > 0) {
            let option
            query ='?'
            for (option in options) {
                if (options.hasOwnProperty(option)) {
                    query = query + "&" + option + "=" + options[option];
                }
            }
        }

        return query;
    },
    client(options) {
        const base_uri = '/wp-json/my-movie-db/v2/get-data'
        return this.$http.get(base_uri + options).then(response => {
            // success callback
            return response.data
        }, error => {
            console.log(error)
            // error callback
        });

    },
    getById(id) {
        return this.client(this.generateQuery({
            id: id,
            type: this.$store.state.type
        }))
    },
    searchAPI(query) {
        return this.client(this.generateQuery({
            query: query,
            type: this.$store.state.type
        }))
    }
}

export default {
    methods
}