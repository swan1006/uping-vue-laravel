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
          .get('/getReports', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchReport(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/getReport/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
