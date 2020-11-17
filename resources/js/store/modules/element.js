import { reject } from "lodash";

export default {
    namespaced: true,
    state: () => ({
        project_id: null,
        elements: [],
    }),
    mutations: {
        SET(state, elements) {
            state.elements = elements;
        },
        SET_PROJECT_ID(state, project_id) {
            state.project_id = project_id;
        }
    },
    getters: {
        elements: (state) => state.elements,
        project_id: (state) => state.project_id
    },
    actions: {
        save({state, commit }, {id, data}) {
            return new Promise((resolve, reject) => {
                if (!_.isNull(state.project_id)) {
                    axios.post(`/projects/${state.project_id}/elements${(!_.isNull(id))? '/'+id : ''}`, data).then(res => {
                        resolve(res.data);
                    }).catch(err => {
                        reject(err);
                    });
                } else {
                    reject('Project ID must be set');
                }
            })
        },
        remove({ state, commit }, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/projects/${state.project_id}/elements/${id}`).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    reject(err);
                });
            });
        }
    }
}