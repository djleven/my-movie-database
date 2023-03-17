import {ContentId, ContentTypes} from "@/models/settings";

const getEndpoint = '/wp-json/my-movie-db/v2/get-data'
const generateQuery = (endpoint: string, options: {}) => {
    let query = '';
    if (Object.keys(options).length > 0) {
        let option
        query ='?'
        for (option in options) {
            query = query + "&" + option + "=" + options[option];
        }
    }

    return endpoint + query;
}

interface HttpResponse<T> extends Response {
    parsedBody?: T;
}

async function http<T>(request: RequestInfo): Promise<HttpResponse<T>> {
    try {
        const response: HttpResponse<T> = await fetch(request);

        try {
            response.parsedBody = await response.json();
        } catch (ex) {
           // TODO: better error handling and front-end notification
            throw new Error('An error has occurred');
        }

        if (!response.ok) {
            // TODO: better error handling and front-end notification
            throw new Error(response.statusText);
        }
        return response;
    }
    catch (e) {
        // TODO: better error handling and front-end notification
        throw new Error('An error has occurred');
    }
}

export const getById = async ({id, type}: {id: ContentId, type: ContentTypes}): Promise<HttpResponse<any>>  => {
    return get(generateQuery(
        getEndpoint, {
        id: id,
        type: type
    }))
}
export const searchAPI = async (query: string, type: ContentTypes): Promise<HttpResponse<any>> => {
    return get(generateQuery(
        getEndpoint, {
        query: query,
        type: type
    }))
}
async function get<T>(
    path: string,
    args: RequestInit = { method: "get" }
): Promise<HttpResponse<T>> {
    return await http<T>(new Request(path, args));
}

async function post<T>(
    path: string,
    body: any,
    args: RequestInit = { method: "post", body: JSON.stringify(body) }
): Promise<HttpResponse<T>>  {
    return await http<T>(new Request(path, args));
}

async function put<T>(
    path: string,
    body: any,
    args: RequestInit = { method: "put", body: JSON.stringify(body) }
): Promise<HttpResponse<T>> {
    return await http<T>(new Request(path, args));
}