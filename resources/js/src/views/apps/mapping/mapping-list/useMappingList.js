import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useMappingsList() {
  // Use toast
  const toast = useToast()

  const refMappingListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'vendor_id', label: 'Vendor ID', sortable: true },
    { key: 'company.name', label: 'Company', sortable: true },
    { key: 'tiers', label: 'Tiers', sortable: true },
    { key: 'status', label: 'Status', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalMappings = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const roleFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refMappingListTable.value ? refMappingListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalMappings.value,
    }
  })

  const refetchData = () => {
    refMappingListTable.value.refresh()
  }

    function goBack() {
        history.back();
    }


  watch([currentPage, perPage, searchQuery, roleFilter, planFilter, statusFilter], () => {
    refetchData()
  })

  const fetchMappings = (ctx, callback) => {
    store
      .dispatch('app-mapping/fetchMappings', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
        role: roleFilter.value,
        plan: planFilter.value,
        status: statusFilter.value,
      })
      .then(response => {
          // console.log(response.data)
          // debugger
        const { mappings, total } = response.data.mappings

        callback(mappings.data)
        totalMappings.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching mapping list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveMappingRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolveMappingRoleIcon = role => {
    if (role === 'subscriber') return 'MappingIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'MappingIcon'
  }

  const resolveMappingStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }

    const resolveMappingStatusVariantAndIcon = status => {
        if (status === 1) return { variant: 'success', icon: 'CheckCircleIcon' }
        if (status === 2) return { variant: 'secondary', icon: 'ActivityIcon' }
        if (status === 0) return { variant: 'info', icon: 'XIcon' }
        return { variant: 'secondary', icon: 'XIcon' }
    }

    const resolveMappingAvatarVariant = status => {
        if (status === 1) return 'success'
        if (status === 2) return 'secondary'
        if (status === 0) return 'info'
        // if (status === 'Past Due') return 'success'
        return 'primary'
    }


    const leadTypeOptions = [
        { label: 'UK', value: 'paydayuk' },
        { label: 'USA', value: 'paydayus' },
    ]
    const statusOptions = [
        { label: 'Active', value: 1 },
        { label: 'Inactive', value: 0 },
    ]
    // const lead_type_options = [
    //     { label: 'UK', value: 1 },
    //     { label: 'USA', value: 2 },
    // ]


  return {
    fetchMappings,
    tableColumns,
    perPage,
    currentPage,
    totalMappings,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refMappingListTable,

    resolveMappingRoleVariant,
    resolveMappingRoleIcon,
    resolveMappingStatusVariant,
      resolveMappingStatusVariantAndIcon,
      resolveMappingAvatarVariant,
    refetchData,

    // Extra Filters
    roleFilter,
    planFilter,
    statusFilter,

      leadTypeOptions,
      statusOptions,
      goBack
  }
}
