import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchReports(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/partner/getUKReports/1', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchReport(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/partner/getReport/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
