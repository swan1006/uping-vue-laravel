import axios from '@axios'

export default {
  namespaced: true,
  state: {
    cartItemsCount: (() => {
      const userData = JSON.parse(localStorage.getItem('userData'))
      return userData && userData.extras ? userData.extras.eCommerceCartItemsCount : 0
    })(),
  },
  getters: {},
  mutations: {},
  actions: {
    fetchOffers(ctx, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/offers', { params: payload })
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
  },
}
