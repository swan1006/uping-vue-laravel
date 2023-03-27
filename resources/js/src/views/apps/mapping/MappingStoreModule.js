import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchMappings(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/mappings', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchMapping(ctx, { slug }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/mappings/${slug}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addMapping(ctx, MappingData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/admin/mappings', { mapping: MappingData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteMapping(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/mappings/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
  },
}
