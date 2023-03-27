import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function usePostbacksList() {
  // Use toast
  const toast = useToast()

  const refPostbackMappingListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'postback_name', sortable: true },
    { key: 'global', sortable: true },
    // { key: 'status', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalPostbacks = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const roleFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refPostbackMappingListTable.value ? refPostbackMappingListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalPostbacks.value,
    }
  })

  const refetchData = () => {
    refPostbackMappingListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, roleFilter, planFilter, statusFilter], () => {
    refetchData()
  })

  const fetchPostbacks = (ctx, callback) => {
    store
      .dispatch('app-postback/fetchPostbacks', {
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
        const { postbacks, total } = response.data

        callback(postbacks)
        totalPostbacks.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching partners list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolvePostbackMappingRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolvePostbackMappingRoleIcon = role => {
    if (role === 'subscriber') return 'PostbackIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'PostbackIcon'
  }

  const resolvePostbackMappingStatusVariant = global => {
    if (global === 0) return 'warning'
    if (global === 1) return 'success'
    if (global === 2) return 'secondary'
    return 'primary'
  }
    const statusOptions = [
        {label: 'Pending', value: 2},
        {label: 'Active', value: 1},
        {label: 'Inactive', value: 0},
    ]

    function goBack() {
        history.back();
    }


  return {
    fetchPostbacks,
    tableColumns,
    perPage,
    currentPage,
    totalPostbacks,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refPostbackMappingListTable,

    resolvePostbackMappingRoleVariant,
    resolvePostbackMappingRoleIcon,
    resolvePostbackMappingStatusVariant,
    refetchData,

    // Extra Filters
    roleFilter,
    planFilter,
    statusFilter,

    statusOptions,
      goBack,
  }
}
