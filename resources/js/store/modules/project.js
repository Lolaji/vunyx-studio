import video from './video';
import element from './element';

export default {
    namespaced: true,
    modules: {
        video,
        element
    },
    state: () => ({
        projets: []
    }),
    mutations: {
        SET(state, projects) {
            state.projects = projects;
        }
    },
    getters:{},
    actions: {
        addInteractive({ commit, dispatch }, {user_id, data}) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/projects/${user_id}`, data).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    if (err.response)
                        console.error(err.response.data.message);
                });
            });
        },
        delete({ commit }, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/projects/${id}`).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    if (err)
                        console.log(err.response.data.message);
                })
            });
        }
    }
}