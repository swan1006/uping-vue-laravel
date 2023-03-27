import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
      fetchMappingTiers(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get('/admin/mappings', {params: queryParams})
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchMappingTierIDs(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get('/admin/getMappingTierIDs', {params: queryParams})
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

      fetchMappingTier(ctx, {id}) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/mappings/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      addTier(ctx, mappingData) {
          return new Promise((resolve, reject) => {
              axios
                  .post('/admin/mappings', {mappingTier: mappingData})
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      updateMappingTier({commit}, mappingData) {
          return new Promise((resolve, reject) => {
              axios.patch(`/admin/mappings/${mappingData.id}`, mappingData)
                  // .post(`/user/${user.id}`, user)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      deleteMappingTier(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/mappings/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchFilterDataOptions(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get('/admin/fetchFilterDataOptions', { params: queryParams })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  }
}
