import video from './video';
import element from './element';
import setting from './setting';

export default {
    namespaced: true,
    modules: {
        video,
        element,
        setting
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
        addViewer({ commit }, { project_id, data }) {
            return new Promise((resolve, reject) => {
                axios.post(`/projects/${project_id}/viewers`, data).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    reject(err);
                })
            });
        },
        addDomain({ commit }, { project_id, data }) {
            return new Promise((resolve, reject) => { 
                axios.post(`/projects/${project_id}/domains`, data).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    reject(err);
                });
            });
        },
        update({ commit }, { project_id, data }) {
            return new Promise((resolve, reject) => {
                axios.patch(`/projects/${project_id}`, data).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    reject(err);
                })
            });
        },
        removeViewer({ commit }, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/projects/viewers/${id}`).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    reject(err);
                });
            });
        },
        removeDomain({ commit }, domain_id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/projects/domains/${domain_id}`).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    reject(err);
                });
            });
        },
        delete({ commit }, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/projects/${id}`).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    reject(err);
                })
            });
        }
    }
}