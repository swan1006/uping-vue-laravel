import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchAdvertisers(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/advertisers', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchUserIds(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/fetchUserIds', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchAdvertiser(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/advertisers/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteAdvertiser(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/advertisers/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    addAdvertiser(ctx, advertiserData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/advertisers', { advertiser: advertiserData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      updateAccountForm({commit}, advertiserData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/advertisers/${advertiserData.id}`, advertiserData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

      updateCompanyInfo({commit}, advertiserData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/company/${advertiserData.id}`, advertiserData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
