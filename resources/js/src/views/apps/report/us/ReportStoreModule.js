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
          .get('/admin/getUSReports', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchFilterData(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get('/admin/fetchFilterUSData', { params: queryParams })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
  },
}
