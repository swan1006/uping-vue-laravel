import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchPostbacks(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/partner/getPostbacks/9`, { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchPostback(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/partner/getPostback/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deletePostback(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/partner/postbacks/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    addPostback(ctx, postbackData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/partner/postbacks', { postback: postbackData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      updatePostback({commit}, postbackData) {
          return new Promise((resolve, reject) => {
              axios
                  .patch(`/partner/postbacks/${postbackData.id}`, postbackData)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
  },
}
