import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchInvoices(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/getAllInvoices', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchInvoice(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/invoices/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchBuyerInvoice(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/invoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchBuyerInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/getBuyerInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchTierInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/getTierInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchPartnerInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/getPartnerInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchAdvertiserInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/getAdvertiserInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchCompanyInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/getCompanyInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    fetchClients() {
      return new Promise((resolve, reject) => {
        axios
          .get('/getAllCompanies')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
