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
          .get('/admin/uk-lead', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchUKLead(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/uk-lead/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      getUkLeadLog(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/getUkLeadLog/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
