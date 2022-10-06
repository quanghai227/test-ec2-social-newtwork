//commmit set lazy load page
const SET_LOADING = 'setLoading'
export default {
    state: {
        isLoading: false,
    },
    mutations: {
        [SET_LOADING]: (state, payload) => {
            state.isLoading = payload;
        },
    },
    actions: {
        [SET_LOADING]: ({commit}, payload) => {
            commit([SET_LOADING], payload);
        }
    }
}