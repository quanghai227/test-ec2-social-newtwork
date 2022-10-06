import http from '../../services';
import {url} from '@/configs/configURL';

const userLocal = JSON.parse(sessionStorage.getItem('user'));
const token = JSON.parse(sessionStorage.getItem('token'));

export default {
    state: {
        user: {
            id: userLocal ? userLocal.id : '',
            username: userLocal ? userLocal.username : '',
            email: userLocal ? userLocal.email : '',
            avatar: userLocal ? userLocal.avatar : '',
        },
        token: token ? token: '',
    },

    getters: {
        isLoggedIn (state) {
            return state.token ? true : false;
        },
        getUser(state) {
            return state.user;
        },
        getToken(state) {
            return state.token;
        }
    },

    mutations: {
        setAuthentication(state, payload) {
            state.user = payload.user;
            state.token = payload.access_token;

            sessionStorage.setItem('user', JSON.stringify(payload.user));
            // localStorage.setItem('token', JSON.stringify(payload.access_token));
            sessionStorage.setItem('token', JSON.stringify(payload.access_token));
        },
        updateStateUser(state, payload) {
            state.user = payload;

            sessionStorage.setItem('user', JSON.stringify(state.user));
        }
    },

    actions: {
        async register({commit}, payload) {
            const result = await http.post(url.REGISTER, payload);
            // commit('setAuthentication', result.data)
            return result;
        },

        async login({commit}, payload) {
            const result = await http.post(url.LOGIN, payload);

            if (result && result.status) {
                commit('setAuthentication', result.resultData);
                // localStorage.setItem('user', JSON.stringify(result.data.user));
            }
            return result;
        },

        async logout({commit}, payload) {
            commit('setAuthentication', {user: {}, token: ''})
            sessionStorage.removeItem('token');
            return true;
        },

        async getUserProfile({commit}, payload) {
            const result = await http.get(url.USER_PROFILE.replace('{id}', payload));
            return result;
        },

        async updateUserProfile({commit}, payload) {
            const result = await http.post(url.UPDATE_PROFILE.replace('{id}', payload.id), payload.data);
            if (result && result.status) {
                commit('updateStateUser', result.resultData);
            }
            return result;
        },
    },
}
