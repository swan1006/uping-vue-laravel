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
          .get('/admin/getOfferReports', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
