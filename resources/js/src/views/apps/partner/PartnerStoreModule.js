import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchPartners(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/partners', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchPartner(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/partners/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addPartner(ctx, partnerData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/partners', { partner: partnerData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deletePartner(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/partners/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      updatePartner({commit}, partnerData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/partners/${partnerData.id}`, partnerData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      updateCompanyInfo({commit}, partnerData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/company/${partnerData.id}`, partnerData)
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

      updatePartnerPaymentInfo({commit}, partnerData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/admin/payment/${partnerData.id}`, partnerData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      }


  },
}
