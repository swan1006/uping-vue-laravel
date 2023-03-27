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
          .get('/admin/invoices', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchInvoice(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/invoices/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchBuyerInvoice(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/invoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchBuyerInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/getBuyerInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchTierInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/getTierInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchPartnerInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/getPartnerInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchAdvertiserInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/getAdvertiserInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchCompanyInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/getCompanyInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    fetchClients() {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/getAllCompanyData')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteInvoice(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/admin/invoices/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      sendInvoice(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/sendInvoice/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
