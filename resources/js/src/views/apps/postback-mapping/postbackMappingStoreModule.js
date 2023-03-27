import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchPostbackMappings(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/postbacks', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchPostbackMapping(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/getPostbackMapping/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deletePostbackMapping(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/admin/postbacks/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addPostbackMapping(ctx, postbackData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/postbacks', { postback: postbackData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      updatePostbackMapping({commit}, postbackMappingData) {
        // console.log(postbackMappingData)
        // console.log(postbackMappingData.id)
          debugger
          return axios.patch(`/admin/postbacks/${postbackMappingData.id}`, postbackMappingData)
              // .post(`/user/${user.id}`, user)
              .then((res) => {
                  console.log(res)
                  debugger
                  // commit('setCurrentSurvey', res.data)
                  return res;
              })
      },

  },
}
