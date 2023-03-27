import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useMappingTierList() {
  // Use toast
  const toast = useToast()

  const refMappingTierListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'leadtype', label: 'Lead Type', sortable: true },
    { key: 'buyer_id', label: 'Buyer ID', sortable: true },
    { key: 'buyer_setup_id', label: 'Tier ID', sortable: true },
    { key: 'status', label: 'Status', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalMappingTier = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)

  const leadTypeFilter = ref(null)
  const buyerFilter = ref(null)
  const tierFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refMappingTierListTable.value ? refMappingTierListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalMappingTier.value,
    }
  })

  const refetchData = () => {
    refMappingTierListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, leadTypeFilter, buyerFilter, tierFilter, statusFilter], () => {
    refetchData()
  })

  const fetchMappingTiers = (ctx, slug, callback) => {
    store
      .dispatch(`app-mapping-tier/getMappingTiers/${slug}`, {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,

        leadType: leadTypeFilter.value,
        buyer: buyerFilter.value,
        tier: tierFilter.value,
        status: statusFilter.value,
      })
      .then(response => {
          console.log(response.data)
          debugger
        const { mappingData, total } = response.data

        callback(mappingData)
        totalMappingTier.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching MappingTier list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  const fetchMappingTier = (ctx, callback) => {
        store
            .dispatch('app-mapping-tier/fetchMappingTier', {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,
                leadType: leadTypeFilter.value,
                buyer: buyerFilter.value,
                tier: tierFilter.value,
                status: statusFilter.value,
            })
            .then(response => {
                const { mapping, total } = response.data

                console.log(response.data)
                console.log(mapping)
                console.log(total)
                debugger
                callback(mapping)
                totalMappingTier.value = total
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: 'Error fetching MappingTier list',
                        icon: 'AlertTriangleIcon',
                        variant: 'danger',
                    },
                })
            })
    }

    function goBack() {
        history.back();
    }


    // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveMappingTierRoleVariant = leadType => {
    if (leadType === 'subscriber') return 'primary'
    if (leadType === 'author') return 'warning'
    if (leadType === 'maintainer') return 'success'
    if (leadType === 'editor') return 'info'
    if (leadType === 'admin') return 'danger'
    return 'primary'
  }

  const resolveMappingTierRoleIcon = leadType => {
    if (leadType === 'subscriber') return 'BuyerSetupIcon'
    if (leadType === 'author') return 'SettingsIcon'
    if (leadType === 'maintainer') return 'DatabaseIcon'
    if (leadType === 'editor') return 'Edit2Icon'
    if (leadType === 'admin') return 'ServerIcon'
    return 'BuyerSetupIcon'
  }

  const resolveMappingTierStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }
  const resolveMappingTierModeVariant = status => {
    if (status === 'inactive') return 'warning'
    if (status === 'live') return 'success'
    if (status === 'test') return 'secondary'
    return 'primary'
  }
  const resolveMappingTierModelTypeVariant = model_type => {
    if (model_type === 'CPA') return 'warning'
    if (model_type === 'CPL') return 'success'
    if (model_type === 'CPF') return 'secondary'
    if (model_type === 'Hybrid') return 'secondary'
    return 'primary'
  }
    const resolveMappingTierRotationVariant = rotation => {
        if (rotation === 1) return 'success'
        if (rotation === 0) return 'warning'
        return 'primary'
    }
    const leadTypeOptions = [
        { label: 'UK', value: 1 },
        { label: 'USA', value: 2 },
    ]
    const statusOptions = [
        { label: 'Active', value: 1 },
        { label: 'Inactive', value: 0 },
    ]



  return {
    fetchMappingTiers,
    tableColumns,
    perPage,
    currentPage,
    totalMappingTier,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refMappingTierListTable,



    resolveMappingTierRoleVariant,
    resolveMappingTierRoleIcon,
    resolveMappingTierStatusVariant,
    resolveMappingTierModeVariant,
    resolveMappingTierModelTypeVariant,
    resolveMappingTierRotationVariant,
    refetchData,

    // Extra Filters
    leadTypeFilter,
    buyerFilter,
    tierFilter,
    statusFilter,

      statusOptions,
      leadTypeOptions,

      goBack,
      fetchMappingTier
  }
}
