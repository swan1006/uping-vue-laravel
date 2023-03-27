import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useOffersList() {
  // Use toast
  const toast = useToast()

  const refOfferListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'name', sortable: true },
    { key: 'privacy_level', sortable: true },
    { key: 'conversion_type', sortable: true },
    { key: 'category', sortable: true },
    { key: 'geos', sortable: true },
    { key: 'status', sortable: true },
    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalOffers = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const roleFilter = ref(null)
  const planFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refOfferListTable.value ? refOfferListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalOffers.value,
    }
  })

  const refetchData = () => {
    refOfferListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, roleFilter, planFilter, statusFilter], () => {
    refetchData()
  })

  const fetchOffers = (ctx, callback) => {
    store
      .dispatch('app-offer/fetchOffers', {
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
        const { offers, total } = response.data

        callback(offers)
        totalOffers.value = total
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

  const resolveOfferRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolveOfferRoleIcon = role => {
    if (role === 'subscriber') return 'OfferIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'OfferIcon'
  }

  const resolveOfferStatusVariant = status => {
    if (status === 'pending') return 'warning'
    if (status === 'active') return 'success'
    if (status === 'inactive') return 'secondary'
    return 'primary'
  }
    const resolveOfferAvatarVariant = status => {
        if (status === 'Partial Payment') return 'primary'
        if (status === 'Paid') return 'danger'
        if (status === 'Downloaded') return 'secondary'
        if (status === 'Draft') return 'warning'
        if (status === 'Sent') return 'info'
        if (status === 'Past Due') return 'success'
        return 'primary'
    }

    const statusOptions = [
        { label: 'Active', value: 1 },
        { label: 'Inactive', value: 0 },
    ]
    const internalOptions = [
        { label: 'Internal Offer', value: 1 },
        { label: 'External Offer', value: 0 },
    ]
    const categoryOptions = [
        { label: 'Apps', value: 'Apps' },
        { label: 'Finance', value: 'Finance' },
        { label: 'Dating', value: 'Dating' },
        { label: 'Sweepstake', value: 'Sweepstake' },
        { label: 'Gambling', value: 'Gambling' },
        { label: 'Gaming', value: 'Gaming' },
        { label: 'Adult', value: 'Adult' },
        { label: 'Other', value: 'Other' },
    ]
    const geoOptions = [
        { label: 'TEST', value: 1 },
    ]
    const conversionActionOptions = [
        { label: 'SOI', value: 'pending' },
    ]
    const conversionTypeOptions = [
        { label: 'CPA', value: 'pending' },
        { label: 'CPL', value: 'active' },
        { label: 'CPS', value: 'inactive' },
    ]
    const privacyLevelOptions = [
        { label: 'Pending', value: 'pending' },
        { label: 'Active', value: 'active' },
        { label: 'Inactive', value: 'inactive' },
    ]

    function goBack() {
      history.goback()
    }


  return {
      internalOptions,
      categoryOptions,
      geoOptions,
      conversionActionOptions,
      conversionTypeOptions,
      privacyLevelOptions,
      statusOptions,




    fetchOffers,
    tableColumns,
    perPage,
    currentPage,
    totalOffers,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refOfferListTable,

    resolveOfferRoleVariant,
    resolveOfferRoleIcon,
    resolveOfferStatusVariant,
      resolveOfferAvatarVariant,
    refetchData,

    // Extra Filters
    roleFilter,
    planFilter,
    statusFilter,
      goBack,
  }
}
