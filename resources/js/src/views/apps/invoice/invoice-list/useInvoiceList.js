import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useInvoicesList() {
  // Use toast
  const toast = useToast()

  const refInvoiceListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', label: '#', sortable: true },
    { key: 'invoiceStatus', label: 'Status', sortable: true },
    { key: 'client', label: 'Client', sortable: true },
    { key: 'grand_total', label: 'Sub Total', sortable: true, formatter: val => `$${val}` },
    { key: 'issuedDate', label: 'Issue Date', sortable: true },
    { key: 'balance', label: 'Balance', sortable: true },
    // { key: 'invoiceStatus', label: 'Status', sortable: true },
      { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalInvoices = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refInvoiceListTable.value ? refInvoiceListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalInvoices.value,
    }
  })

  const refetchData = () => {
    refInvoiceListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, statusFilter], () => {
    refetchData()
  })

  const fetchInvoices = (ctx, callback) => {
    store
      .dispatch('app-invoice/fetchInvoices', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
        status: statusFilter.value,
      })
      .then(response => {
        const { invoices, total } = response.data

        callback(invoices)
        totalInvoices.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: "Error fetching invoices' list",
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveInvoiceStatusVariantAndIcon = invoiceStatus => {
    if (invoiceStatus === 1) return { variant: 'success', icon: 'CheckCircleIcon' }
    if (invoiceStatus === 2) return { variant: 'warning', icon: 'PieChartIcon' }
    if (invoiceStatus === 3) return { variant: 'info', icon: 'ArrowDownCircleIcon' }
    if (invoiceStatus === 4) return { variant: 'primary', icon: 'SaveIcon' }
    if (invoiceStatus === 5) return { variant: 'secondary', icon: 'SendIcon' }
    if (invoiceStatus === 6) return { variant: 'danger', icon: 'InfoIcon' }
    return { variant: 'secondary', icon: 'XIcon' }
  }

  const resolveClientAvatarVariant = status => {
    if (status === 1) return 'primary'
    if (status === 2) return 'danger'
    if (status === 3) return 'secondary'
    if (status === 4) return 'warning'
    if (status === 5) return 'info'
    if (status === 6) return 'success'
    return 'primary'
  }

  return {
    fetchInvoices,
    tableColumns,
    perPage,
    currentPage,
    totalInvoices,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refInvoiceListTable,

    statusFilter,

    resolveInvoiceStatusVariantAndIcon,
    resolveClientAvatarVariant,

    refetchData,
  }
}
