<template>
    <div>

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="buyerFilterData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching Filter data
            </h4>
            <div class="alert-body">
                No user found with this Filter id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-buyer-filter-list'}"
                >
                    Filter List
                </b-link>
                for other buyer-filter.
            </div>
        </b-alert>

        <template v-if="buyerFilterData">
            <!-- First Row -->
            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                >
                    <buyer-filter-view-user-info-card :buyer-filter-data="buyerFilterData" />
                </b-col>
            </b-row>

            <b-row>
                <b-col
                    cols="12"
                    lg="6"
                >
                </b-col>
                <b-col
                    cols="12"
                    lg="6"
                >
                </b-col>
            </b-row>

            <filter-list :buyer-filter-data="buyerFilterData" />
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
    // import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
    import FilterList from '@/views/apps/filter/filter-list/FilterList.vue'
    import buyerFilterStoreModule from '../buyerFilterStoreModule'
    import BuyerFilterViewUserInfoCard from './BuyerFilterViewUserInfoCard.vue'
    import BuyerFilterViewUserPlanCard from './BuyerFilterViewUserPlanCard.vue'
    import BuyerFilterViewUserTimelineCard from './BuyerFilterViewUserTimelineCard.vue'
    import BuyerFilterViewUserPermissionsCard from './BuyerFilterViewUserPermissionsCard.vue'

    export default {
        components: {
            BRow,
            BCol,
            BAlert,
            BLink,

            // Local Components
            BuyerFilterViewUserInfoCard,
            BuyerFilterViewUserPlanCard,
            BuyerFilterViewUserTimelineCard,
            BuyerFilterViewUserPermissionsCard,

            // InvoiceList,
            FilterList,
        },
        setup() {
            const buyerFilterData = ref(null)

            const BUYER_FILTER = 'app-buyer-filter'

            // Register module
            if (!store.hasModule(BUYER_FILTER)) store.registerModule(BUYER_FILTER, buyerFilterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(BUYER_FILTER)) store.unregisterModule(BUYER_FILTER)
            })

            store.dispatch('app-buyer-filter/fetchBuyerFilter', { id: router.currentRoute.params.id })
                .then(response => { buyerFilterData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        buyerFilterData.value = undefined
                    }
                })

            return {
                buyerFilterData,
            }
        },
    }
</script>

<style>

</style>
