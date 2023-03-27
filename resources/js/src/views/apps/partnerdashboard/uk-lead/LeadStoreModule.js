import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchUKLeads(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/getUKLeads', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchUKLead(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/getUKLead/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
