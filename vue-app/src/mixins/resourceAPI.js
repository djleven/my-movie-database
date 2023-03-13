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
    async client(options) {
        const base_uri = '/wp-json/my-movie-db/v2/get-data'
        try {
            return this.httpGetAsync(base_uri + options)
        } catch (e) {
            console.error(e, 'Error from XMLHttpRequest')
        }
    },
    async httpGetAsync(theUrl, method = "GET", headers = null) {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest();
            xhr.open(method, theUrl);
            xhr.responseType = 'json';
            if (headers) {
                Object.keys(headers).forEach(key => {
                    xhr.setRequestHeader(key, headers[key]);
                });
            }
            xhr.onload = () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    resolve(xhr.response);
                } else {
                    reject(xhr.statusText);
                }
            };
            xhr.onerror = () => reject(xhr.statusText);
            xhr.send();
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