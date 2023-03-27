import axios from '@axios'

export default {
  namespaced: true,
  state: {
      loadingStatus: false,
  },
  getters: {
      loadingStatus (state) {
          return state.loadingStatus
      }
  },
  mutations: {
      loadingStatus (state, newLoadingStatus) {
          state.loadingStatus = newloadingStatus
      }
  },
  actions: {
      getBuyerTiers(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/tiers', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchBuyerTier(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/tiers/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteBuyerTier(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/tiers/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    addTier(ctx, buyerTierData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/tiers', { buyerTier: buyerTierData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      updateBuyerTierForm({commit}, tierData) {
        return new Promise((resolve, reject) => {
            axios
                .patch(`/tiers/${tierData.id}`, tierData)
                .then(response => resolve(response))
                .catch(error => reject(error))
        })
      },
  },
}
