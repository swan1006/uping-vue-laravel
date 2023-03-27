import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useLeadList() {
  // Use toast
  const toast = useToast()

  const refUKLeadsListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'vid', sortable: true },
    { key: 'subid', sortable: true },
    { key: 'tier', sortable: true },
    { key: 'vidLeadPrice', sortable: true },
    { key: 'buyerLeadPrice', sortable: true },
    { key: 'Profit', sortable: true },
    { key: 'leadStatus', sortable: true },
    { key: 'quality_score', sortable: true },
    { key: 'checkStatus', sortable: true },
    { key: 'isRedirected', sortable: true },
    { key: 'created_at', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalUKLeads = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const roleFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refUKLeadsListTable.value ? refUKLeadsListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalUKLeads.value,
    }
  })

  const refetchData = () => {
    refUKLeadsListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, roleFilter, planFilter, statusFilter], () => {
    refetchData()
  })

  const fetchUKLeads = (ctx, callback) => {
    store
      .dispatch('app-uk-leads/fetchUKLeads', {
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
        const { leads, total } = response.data

        callback(leads)
        totalUKLeads.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching users list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveUKLeadsRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolveUKLeadsRoleIcon = role => {
    if (role === 'subscriber') return 'UKLeadsIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'UKLeadsIcon'
  }

  const resolveUKLeadsStatusVariant = leadStatus => {
    if (leadStatus === 'declined') return 'warning'
    if (leadStatus === 'sold') return 'success'
    if (leadStatus === 'pending') return 'secondary'
    return 'primary'
  }

  return {
    fetchUKLeads,
    tableColumns,
    perPage,
    currentPage,
    totalUKLeads,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refUKLeadsListTable,

    resolveUKLeadsRoleVariant,
    resolveUKLeadsRoleIcon,
    resolveUKLeadsStatusVariant,
    refetchData,

    // Extra Filters
    roleFilter,
    planFilter,
    statusFilter,
  }
}
