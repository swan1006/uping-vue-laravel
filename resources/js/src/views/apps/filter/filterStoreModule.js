import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchFilters(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/buyer-filters', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchSelectOptions(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/buyer-filters/fetchSelectOptions', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchFilter(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/buyer-filters/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchIndividualFilter(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/buyer-filters/fetchIndividualFilter/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchFilterList(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/buyer-filters/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      deleteFilter(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/buyer-filters/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

    addFilter(ctx, filterData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/buyer-filters', { filter: filterData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      updateFilter({commit}, filterData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/buyer-filters/${filterData.id}`, filterData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
