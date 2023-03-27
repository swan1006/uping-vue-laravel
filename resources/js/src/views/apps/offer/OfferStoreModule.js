import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchOffers(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/offers', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchOffer(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/offers/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteOffer(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/offers/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    addOffer(ctx, offerData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/offers', { offer: offerData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      updateOffer({commit}, offerData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/offers/${offerData.id}`, offerData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
