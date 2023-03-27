import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchBuyerFilters(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/buyer-filters', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchBuyerFilter(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/buyer-filters/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addBuyerFilter(ctx, buyerFiltersData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/buyer-filters', { buyerFilters: buyerFiltersData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
