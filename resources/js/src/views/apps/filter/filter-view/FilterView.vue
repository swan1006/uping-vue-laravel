<template>
    <div>

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="filterData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching filter data
            </h4>
            <div class="alert-body">
                No user found with this filter id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-filter-list'}"
                >
                    Filter Data
                </b-link>
                for other-filter.
            </div>
        </b-alert>

        <template v-if="filterData">
            <!-- First Row -->
            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                >
                    <filter-view-user-info-card
                        :single-filter-data="filterData" />
                </b-col>
            </b-row>

        </template>

    </div>
</template>

<script>
    import store from '@/store'
    import router from '@/router'
    import { ref, onUnmounted } from '@vue/composition-api'
    import {
        BRow, BCol, BAlert, BLink,
    } from 'bootstrap-vue'
    import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
    import filterStoreModule from '../filterStoreModule'
    import FilterViewUserInfoCard from './FilterViewUserInfoCard.vue'
    import FilterViewUserPlanCard from './FilterViewUserPlanCard.vue'
    import FilterViewUserTimelineCard from './FilterViewUserTimelineCard.vue'
    import FilterViewUserPermissionsCard from './FilterViewUserPermissionsCard.vue'

    export default {
        components: {
            BRow,
            BCol,
            BAlert,
            BLink,

            // Local Components
            FilterViewUserInfoCard,
            FilterViewUserPlanCard,
            FilterViewUserTimelineCard,
            FilterViewUserPermissionsCard,

        },
        setup() {
            const filterData = ref(null)

            const FILTERS = 'app-filter'

            // Register module
            if (!store.hasModule(FILTERS)) store.registerModule(FILTERS, filterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(FILTERS)) store.unregisterModule(FILTERS)
            })


            store.dispatch('app-filter/fetchIndividualFilter', { id: router.currentRoute.params.id })
                .then(response => { filterData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        filterData.value = undefined
                    }
                })

            return {
                filterData,
            }
        },
    }
</script>

<style>

</style>
