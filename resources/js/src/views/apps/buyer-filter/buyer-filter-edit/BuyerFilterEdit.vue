<template>
    <component :is="buyerFilterData === undefined ? 'div' : 'b-card'">

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="buyerFilterData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching buyerFilter data
            </h4>
            <div class="alert-body">
                No buyerFilter found with this buyerFilter id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-buyer-filters-list'}"
                >
                    buyerFilter List
                </b-link>
                for other buyerFilters.
            </div>
        </b-alert>

        <b-tabs
            v-if="buyerFilterData"
            pills
        >

            <!-- Tab: Account -->
            <b-tab active>
                <template #title>
                    <feather-icon
                        icon="buyerFilterIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Account</span>
                </template>
                <buyer-filter-edit-tab-account
                    :buyer-filter-data="buyerFilterData"
                    class="mt-2 pt-75"
                />
            </b-tab>

            <!-- Tab: Information -->
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Information</span>
                </template>
                <buyerFilter-edit-tab-information
                    :buyer-filter-data="buyerFilterData"
                    class="mt-2 pt-75"
                />
            </b-tab>



        </b-tabs>
    </component>
</template>

<script>
    import {
        BTab, BTabs, BCard, BAlert, BLink,
    } from 'bootstrap-vue'
    import { ref, onUnmounted } from '@vue/composition-api'
    import router from '@/router'
    import store from '@/store'
    import buyerFilterStoreModule from '../buyerFilterStoreModule'
    import BuyerFilterEditTabAccount from './BuyerFilterEditTabAccount.vue'
    import BuyerFilterEditTabInformation from './BuyerFilterEditTabInformation.vue'

    export default {
        components: {
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,

            BuyerFilterEditTabAccount,
            BuyerFilterEditTabInformation,
        },

        setup() {

            const buyerFilterData = ref(null)

            const BUYERFILTER_APP_STORE_MODULE_NAME = 'app-buyer-filter'

            // Register module
            if (!store.hasModule(BUYERFILTER_APP_STORE_MODULE_NAME)) store.registerModule(BUYERFILTER_APP_STORE_MODULE_NAME, buyerFilterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(BUYERFILTER_APP_STORE_MODULE_NAME)) store.unregisterModule(BUYERFILTER_APP_STORE_MODULE_NAME)
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
