import axios from '@axios'

export default {
  namespaced: true,
  state: {
      userData: {
          data: {},
      },



  },
  getters: {},
  mutations: {
      // setUserData: (state, survey) => {
      //     state.setUserData.data = survey.data;
      // },

  },
  actions: {
      fetchUsers(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/users', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      addUser(ctx, userData) {
          return new Promise((resolve, reject) => {
              axios
                  .post('/admin/users', { user: userData })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

      fetchUser(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/users/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteUser(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/users/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
  },
      editUser(ctx, userData) {
          return new Promise((resolve, reject) => {
              axios
                  .post('/admin/users/edit/', { user: userData })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      updateAccountForm({commit}, userData) {
          return new Promise((resolve, reject) => {
            axios
              .patch(`/admin/users/${userData.id}`, userData)
              .then(response => resolve(response))
              .catch(error => reject(error))
          })
      },
      updateCompanyInfo({commit}, userData) {
          return new Promise((resolve, reject) => {
          axios
              .patch(`/admin/company/${userData.id}`, userData)
              .then(response => resolve(response))
              .catch(error => reject(error))
      })
      },
      updateUserPaymentInfo({commit}, userData) {
          return new Promise((resolve, reject) => {
          axios
              .patch(`/admin/payment/${userData.id}`, userData)
              .then(response => resolve(response))
              .catch(error => reject(error))
      })
      }
  },
}
