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
          .get('/admin/postbacks', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchPostback(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/postbacks/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deletePostback(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/postbacks/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    addPostback(ctx, postbackData) {
        console.log(postbackData)
        debugger
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/postbacks', { postback: postbackData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchFilterData(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get('/admin/fetchFilterUKData', { params: queryParams })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
