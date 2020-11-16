import Axios from "axios";
import { reject } from "lodash"

export default {
    namespaced: true,
    state: () => ({
        
    }),
    mutations: {},
    getters: {},
    actions: {
        save({ commit }, { project_id, data }) {
            return new Promise((resolve, reject) => { 
                axios.patch(`/projects/${project_id}/settings`, data).then(res => {
                    resolve(res.data);
                }).catch(err => {
                    if (err.response)
                        console.error(err.response.data.message);
                });
            });
        }
    }
}