import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'
import authStore from './modules/authStore'
import commonStore from './modules/commonStore'
import friendStore from './modules/friendStore'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {},
    getters,
    modules: {
        authStore,
        commonStore,
        friendStore,
    }
})
