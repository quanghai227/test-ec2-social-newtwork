import {
    HTTP_STATUS_OK,
    HTTP_STATUS_SERVER_ERROR,
    HTTP_STATUS_UNAUTHORIZED,
    HTTP_STATUS_UNPROCESSABLE,
    SERVER_ERROR_MESSAGE
} from '../configs/constantHTTP';
import authHeader from './auth-header';

import commonStore from '../stores';

export const http = {
    async request(method, url, data, options = {}) {
        axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
        const result = await axios.request(
        {
            url: '/api' + url,
            method: method.toUpperCase(),
            headers: authHeader(),
            data: data,
            param: options,
        }).catch(err => {
            return this.handlerResponseError(err.response);
        });
        
        return new Promise((resolve) => resolve(this.handlerResponse(result)));
    },

    get(url, options = {}) {
        const result = this.request('get', url, {}, options);
        return result;
    },

    post(url, data, options = {}) {
        commonStore.commit('setLoading', true);
        const result = this.request('post', url, data, options);
        
        commonStore.commit('setLoading', false);
        return result;
    },

    put(url, data, options) {
        return this.request('put', url, data, options);
    },

    delete(url, data = {}, options) {
        return this.request('delete', url, data, options);
    },

    async handlerResponse(response) {
        if (response.status == HTTP_STATUS_OK)
        {
            return {
                status: true,
                statusCode: response.status,
                resultData: response.data,
            };
        }
        return response;
    },
    async handlerResponseError(response) {
        switch (response.status) {
            case HTTP_STATUS_UNAUTHORIZED:
                return {
                    status: false,
                    statusCode: response.status,
                    message: response.data.message
                };
            case HTTP_STATUS_UNPROCESSABLE:
                return {
                    status: false,
                    statusCode: response.status,
                    errors: response.data.errors,
                    message: response.data.message
                };
            case HTTP_STATUS_SERVER_ERROR:
                return {
                    status: false,
                    statusCode: response.status,
                    message: SERVER_ERROR_MESSAGE,
                };
            default: {
                return response;
            }
        };
    },
    handlerEmpty() {
        return {
            status: false,
            statusCode: 0,
            message: null,
        };
    }
}

export default http
