let _userInfo = localStorage.getItem('user');
let _role = localStorage.getItem('role');

export default {
    namespaced: true,

    state: () => ({
        user: JSON.parse(_userInfo) || null,
        role: _role || null,
    }),

    mutations: {
        setAuthInfo: function (state, data) {
            state.user = data.user;
            state.role = data.role;
            let user = JSON.stringify(data.user);
            localStorage.setItem('user', user);
            localStorage.setItem('role', data.role);
        },
        removeAuthInfo: function (state) {
            state.role = null;
            state.user = null;
        }
    },

    actions: {
        logout(context) {
            localStorage.removeItem('user');
            context.commit('removeAuthInfo');
        },
        loginStore(context, data) {
            context.commit('setAuthInfo', data);
        }
    }
}