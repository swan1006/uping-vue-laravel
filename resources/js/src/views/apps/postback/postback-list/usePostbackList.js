import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function usePostbacksList() {
  // Use toast
  const toast = useToast()

  const refPostbackListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', label: 'ID',sortable: true },
    { key: 'vendor_id', label: 'Vendor ID',sortable: true },
    { key: 'company.name', label: 'Company',sortable: true },
    { key: 'Postbacks', label: 'Postbacks',sortable: true },
    { key: 'status', label: 'Status',sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalPostbacks = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const affIdFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refPostbackListTable.value ? refPostbackListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalPostbacks.value,
    }
  })

  const refetchData = () => {
    refPostbackListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, affIdFilter, planFilter, statusFilter], () => {
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
        affId: affIdFilter.value,
        plan: planFilter.value,
        status: statusFilter.value,
      })
      .then(response => {
        const { postbacks, total } = response.data

        callback(postbacks.data)
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

  const resolvePostbackRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolvePostbackRoleIcon = role => {
    if (role === 'subscriber') return 'PostbackIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'PostbackIcon'
  }

  const resolvePostbackStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }

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
    refPostbackListTable,

    resolvePostbackRoleVariant,
    resolvePostbackRoleIcon,
    resolvePostbackStatusVariant,
    refetchData,
    goBack,

    // Extra Filters
    affIdFilter,
    planFilter,
    statusFilter,
  }
}
