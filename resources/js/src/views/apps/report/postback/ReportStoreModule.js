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
          .get('/admin/getPostbackReports', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchFilterData(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get('/admin/fetchFilterPostbackData', { params: queryParams })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
