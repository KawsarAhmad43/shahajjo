export default {
    namespaced: true,

    state: () => ({
        site: {},
        global: {},
        menus: {},
        permissions: {},
        sliderPosition: {},
        sliderButtonTypes:{},
    }),

    mutations: {
        setGlobalData(state, data) {
            state.site = data.site;
            state.menus = data.menus;
            state.global = data.global;
            state.permissions = data.permissions;
            state.sliderPosition = data.sliderPosition;
            state.sliderLists = data.sliderLists;
            state.sliderButtonTypes = data.sliderButtonTypes;

        },
    },

    actions: {
        setGlobal(context, data) {
            context.commit('setGlobalData', data);
        }
    },
}
