import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useBuyersList() {
  // Use toast
  const toast = useToast()

  const refBuyerListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'buyer', label: 'Buyer', sortable: true },
    { key: 'company', label: 'Company', sortable: true },
    { key: 'buyer_type', label: 'Buyer Type', sortable: true },
    { key: 'status', label: 'Status', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalBuyers = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const buyerTypeFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refBuyerListTable.value ? refBuyerListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalBuyers.value,
    }
  })




    const refetchData = () => {
    refBuyerListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, buyerTypeFilter, statusFilter], () => {
    refetchData()
  })

  const fetchBuyers = (ctx, callback) => {
    store
      .dispatch('app-buyers/fetchBuyers', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
        buyerType: buyerTypeFilter.value,
        status: statusFilter.value,
      })
      .then(response => {
        const { buyers, total } = response.data


        callback(buyers.data)
        totalBuyers.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching buyers list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*
    function goBack() {
        history.back();
    }

  const resolveBuyerRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolveBuyerRoleIcon = role => {
    if (role === 'subscriber') return 'BuyerIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'BuyerIcon'
  }
    const resolveBuyerAvatarVariant = status => {
        if (status === 'Partial Payment') return 'primary'
        if (status === 'Paid') return 'danger'
        if (status === 'Downloaded') return 'secondary'
        if (status === 'Draft') return 'warning'
        if (status === 'Sent') return 'info'
        if (status === 'Past Due') return 'success'
        return 'primary'
    }


  const resolveBuyerStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }

    const buyerTypeOptions = [
        { label: 'Lender', value: 1 },
        { label: 'Broker', value: 2 },
    ]

    const statusOptions = [
        { label: 'Active', value: 1 },
        { label: 'Inactive', value: 0 },
    ]




    return {
    fetchBuyers,
    statusOptions,
    buyerTypeOptions,
    tableColumns,
    perPage,
    currentPage,
    totalBuyers,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refBuyerListTable,
    resolveBuyerRoleVariant,
    resolveBuyerRoleIcon,
    resolveBuyerStatusVariant,
        resolveBuyerAvatarVariant,
    refetchData,

    // Extra Filters
    buyerTypeFilter,
    statusFilter,
        goBack,
  }
}
