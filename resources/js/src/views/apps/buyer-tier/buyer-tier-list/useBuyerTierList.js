import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useBuyerTierList() {
  // Use toast
  const toast = useToast()

  const refBuyerTierListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'leadtype', label: 'Lead Type',sortable: true },
    { key: 'buyername', label: 'Name',sortable: true },
    { key: 'model_type', label: 'Model Type',sortable: true },
    { key: 'posting_order', label: 'Posting Order',sortable: true },
    { key: 'mode', label: 'Mode',sortable: true },
    { key: 'status', label: 'Status',sortable: true },
    { key: 'rotate', label: 'Rotate',sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalBuyerTier = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)

  const leadTypeFilter = ref(null)
  const modelTypeFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refBuyerTierListTable.value ? refBuyerTierListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalBuyerTier.value,
    }
  })

  const refetchData = () => {
    refBuyerTierListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, leadTypeFilter, modelTypeFilter, statusFilter], () => {
    refetchData()
  })

  const fetchBuyerTiers = (ctx, callback) => {
    store
      .dispatch(`app-buyer-tier/getBuyerTiers`, {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
        leadType: leadTypeFilter.value,
        modelType: modelTypeFilter.value,
        status: statusFilter.value,
      })
      .then(response => {
        const { buyertiers, total } = response.data
          // console.log(buyertiers)
          // debugger

        callback(buyertiers.data)
        totalBuyerTier.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching BuyerTier list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveBuyerTierRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolveBuyerTierRoleIcon = role => {
    if (role === 'subscriber') return 'BuyerSetupIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'BuyerSetupIcon'
  }

  const resolveBuyerTierStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }
  const resolveBuyerTierModeVariant = status => {
    if (status === 'inactive') return 'warning'
    if (status === 'live') return 'success'
    if (status === 'test') return 'secondary'
    return 'primary'
  }
  const resolveBuyerTierModelTypeVariant = model_type => {
    if (model_type === 'CPA') return 'primary'
    if (model_type === 'CPL') return 'success'
    if (model_type === 'CPF') return 'secondary'
    if (model_type === 'Hybrid') return 'info'
    return 'primary'
  }
    const resolveBuyerTierRotationVariant = rotation => {
        if (rotation === 1) return 'success'
        if (rotation === 0) return 'warning'
        return 'primary'
    }

    function goBack() {
        history.back();
    }



    return {
    fetchBuyerTiers,
    tableColumns,
    perPage,
    currentPage,
    totalBuyerTier,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refBuyerTierListTable,

    resolveBuyerTierRoleVariant,
    resolveBuyerTierRoleIcon,
    resolveBuyerTierStatusVariant,
    resolveBuyerTierModeVariant,
    resolveBuyerTierModelTypeVariant,
    resolveBuyerTierRotationVariant,
    refetchData,

    // Extra Filters
    leadTypeFilter,
    modelTypeFilter,
    statusFilter,
        goBack
  }
}
