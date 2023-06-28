import Vuex from 'vuex'
import auth from './auth'
import global from './global'
import breadcrumb from './breadcrumb'

export default new Vuex.Store({
  state: {
  },

  mutations: {
  },

  actions: {
  },

  modules: {
    auth,
    breadcrumb,
    global
  }
})
