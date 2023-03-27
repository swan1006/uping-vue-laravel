import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function usePartnersList() {
  // Use toast
  const toast = useToast()

  const refPartnerListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', label: 'ID', sortable: true },
    { key: 'partner', label: 'Partner', sortable: true },
    { key: 'partner.vendor_id', label: 'Vendor ID', sortable: true },
    { key: 'company.name', label: 'Name', sortable: true },
    { key: 'company.website', label: 'Website', sortable: true },
    { key: 'status', label: 'Status', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalPartners = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const roleFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refPartnerListTable.value ? refPartnerListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalPartners.value,
    }
  })

  const refetchData = () => {
    refPartnerListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, roleFilter, planFilter, statusFilter], () => {
    refetchData()
  })

  const fetchPartners = (ctx, callback) => {
    store
      .dispatch('app-partners/fetchPartners', {
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
        const { partners, total } = response.data

        callback(partners.data)
        totalPartners.value = total
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

  function goBack() {
    history.back();
  }







    // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolvePartnerRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolvePartnerRoleIcon = role => {
    if (role === 'subscriber') return 'PartnerIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'PartnerIcon'
  }

  const resolvePartnerStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }

    const resolvePartnerAvatarVariant = status => {
        if (status === 'Partial Payment') return 'primary'
        if (status === 'Paid') return 'danger'
        if (status === 'Downloaded') return 'secondary'
        if (status === 'Draft') return 'warning'
        if (status === 'Sent') return 'info'
        if (status === 'Past Due') return 'success'
        return 'primary'
    }

  return {
    tableColumns,
    perPage,
    currentPage,
    totalPartners,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refPartnerListTable,

    fetchPartners,
    resolvePartnerRoleVariant,
    resolvePartnerRoleIcon,
    resolvePartnerStatusVariant,
    resolvePartnerAvatarVariant,
    refetchData,
    goBack,

    // Extra Filters
    roleFilter,
    planFilter,
    statusFilter,
  }
}
