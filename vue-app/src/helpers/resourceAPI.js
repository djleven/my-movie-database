
const generateQuery = (options) => {
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
}
const client = async (options) => {
    const base_uri = '/wp-json/my-movie-db/v2/get-data'
    try {
        return httpGetAsync(base_uri + options)
    } catch (e) {
        console.error(e, 'Error from XMLHttpRequest')
    }
}
const httpGetAsync = async(theUrl, method = "GET", headers = null) => {
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
}
export const getById = ({id, type}) => {
    return client(generateQuery({
        id: id,
        type: type
    }))
}
export const searchAPI = (query,type) => {
    return client(generateQuery({
        query: query,
        type: type
    }))
}

