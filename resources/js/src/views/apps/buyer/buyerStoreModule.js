import axios from '@axios'

export default {
  namespaced: true,
  state: {
  },
  getters: {},
  mutations: {},
  actions: {
    fetchBuyers(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/buyers', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchBuyer(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/buyers/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    addBuyer(ctx, buyerData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/buyers', { buyer: buyerData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteBuyer(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/buyers/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      updateBuyerForm({commit}, buyerData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/buyers/${buyerData.id}`, buyerData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

      updateCompanyInfo({commit}, buyerData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/company/${buyerData.id}`, buyerData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
