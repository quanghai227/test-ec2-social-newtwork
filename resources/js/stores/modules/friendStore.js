import http from '../../services';
import {url} from '@/configs/configURL';

const SET_FRIENDS = 'setFriends';
const SET_FRIENDS_REQUEST = 'setFriendsRequest';

export default {
    state: {
        friends_request: [],
        friends: [],
    },
    getters: {
        getFriendsRequest(state) {
            return state.friends_request; 
        }
    },
    mutations: {
        [SET_FRIENDS]: (state, payload) => {
            state.friends = payload;
        },
        [SET_FRIENDS_REQUEST]: (state, payload) => {
            state.friends_request = payload;
        },
    },
    actions: {
        async requestAddFriend({commit}, payload) {
            const result = await http.post(url.FRIEND_REQUEST, payload);
            // commit([SET_FRIENDS], result.data)
            return result;
        },

        async checkFriend({commit}, payload) {
            const result = await http.post(url.CHECK_FRIEND, payload);
            // commit([SET_FRIENDS], result.data)
            return result;
        },

        async allFriends({commit}) {
            const result = await http.get(url.ALL_FRIENDS);
            
            if (result && result.statusCode == 200) {
                commit(SET_FRIENDS, result.resultData.friends);
            }
            return result;
        },

        async allFriendsRequest({commit}) {
            const result = await http.post(url.ALL_FRIEND_REQUESTS);
            if (result && result.statusCode == 200) {
                commit(SET_FRIENDS_REQUEST, result.resultData.friends_request);
            }
            return result;
        },
    }

}