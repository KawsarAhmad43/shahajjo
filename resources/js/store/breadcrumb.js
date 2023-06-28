export default {
  namespaced: true,

  state: () => ({
    levels: [],
  }),

  actions: {
    storeLevels(context, data) {
      context.commit('pushLevels', data)
    },
  },

  mutations: {
    pushLevels(state, data) {
      state.levels = data;
    },
  },
}