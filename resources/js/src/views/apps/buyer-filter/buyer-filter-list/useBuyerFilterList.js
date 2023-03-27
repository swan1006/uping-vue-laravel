import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useBuyerFiltersList() {
    // Use toast
    const toast = useToast()

    const refBuyerFilterListTable = ref(null)

    // Table Handlers
    const tableColumns = [
        { key: 'id', label: 'ID', sortable: true },
        { key: 'filter_info', icon: 'InfoIcon', sortable: true },
        { key: 'leadtype', label: 'Lead Type', sortable: true },
        { key: 'buyername', label: 'Tier Name', sortable: true },
        { key: 'filter_type', label: 'Filters', sortable: true },
        { key: 'status', label: 'Status', sortable: true },
        { key: 'actions' },
    ]

    const perPage = ref(10)
    const totalBuyerFilters = ref(0)
    const currentPage = ref(1)
    const perPageOptions = [10, 25, 50, 100]
    const searchQuery = ref('')
    const sortBy = ref('id')
    const isSortDirDesc = ref(true)
    const leadTypeFilter = ref(null)
    // const planFilter = ref(null)
    const statusFilter = ref(null)

    const dataMeta = computed(() => {
        const localItemsCount = refBuyerFilterListTable.value ? refBuyerFilterListTable.value.localItems.length : 0
        return {
            from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
            to: perPage.value * (currentPage.value - 1) + localItemsCount,
            of: totalBuyerFilters.value,
        }
    })

    const refetchData = () => {
        refBuyerFilterListTable.value.refresh()
    }

    watch([
        perPage,
        currentPage,
        searchQuery,
        leadTypeFilter,
        statusFilter
    ], () => {
        refetchData()
    })
    function goBack() {
        history.back();
    }


    const fetchBuyerFilters = (ctx, callback) => {
        store
            .dispatch('app-buyer-filters/fetchBuyerFilters', {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,
                leadType: leadTypeFilter.value,
                status: statusFilter.value,
            })
            .then(response => {
                const { buyerFilters, total } = response.data

                callback(buyerFilters.data)
                totalBuyerFilters.value = total
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: 'Error fetching BuyerFilters list',
                        icon: 'AlertTriangleIcon',
                        variant: 'danger',
                    },
                })
            })
    }

    // *===============================================---*
    // *--------- UI ---------------------------------------*
    // *===============================================---*

    const resolveBuyerFilterRoleVariant = role => {
        if (role === 'subscriber') return 'primary'
        if (role === 'author') return 'warning'
        if (role === 'maintainer') return 'success'
        if (role === 'editor') return 'info'
        if (role === 'admin') return 'danger'
        return 'primary'
    }
    const resolveBuyerFilterRoleIcon = role => {
        if (role === 'subscriber') return 'BuyerFilterIcon'
        if (role === 'author') return 'SettingsIcon'
        if (role === 'maintainer') return 'DatabaseIcon'
        if (role === 'editor') return 'Edit2Icon'
        if (role === 'admin') return 'ServerIcon'
        return 'BuyerFilterIcon'
    }
    const resolveBuyerFilterStatusVariant = status => {
        if (status === 'pending') return 'warning'
        if (status === 'active') return 'success'
        if (status === 'inactive') return 'secondary'
        return 'primary'
    }

    const resolveBuyerFilterStatusVariantAndIcon = status => {
        if (status === 1) return { variant: 'success', icon: 'CheckCircleIcon' }
        if (status === 2) return { variant: 'secondary', icon: 'ActivityIcon' }
        if (status === 0) return { variant: 'info', icon: 'XIcon' }
        return { variant: 'secondary', icon: 'XIcon' }
    }

    const resolveBuyerFilterAvatarVariant = status => {
        if (status === 1) return 'success'
        if (status === 2) return 'secondary'
        if (status === 0) return 'info'
        // if (status === 'Past Due') return 'success'
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
        fetchBuyerFilters,
        tableColumns,
        perPage,
        currentPage,
        totalBuyerFilters,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc,
        refBuyerFilterListTable,

        resolveBuyerFilterRoleVariant,
        resolveBuyerFilterRoleIcon,
        resolveBuyerFilterStatusVariant,
        resolveBuyerFilterStatusVariantAndIcon,
        resolveBuyerFilterAvatarVariant,
        refetchData,

        // Extra Filters
        leadTypeFilter,
        statusFilter,

        statusOptions,
        leadTypeOptions,
        goBack,
    }
}
