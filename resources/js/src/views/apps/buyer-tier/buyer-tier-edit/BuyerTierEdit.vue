<template>
    <component :is="buyerTierData === undefined ? 'div' : 'b-card'">

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="buyerTierData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching user data
            </h4>
            <div class="alert-body">
                No user found with this user id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-buyer-tier-list'}"
                >
                    BuyerTier List
                </b-link>
                for other buyer-tier.
            </div>
        </b-alert>

        <b-tabs
            v-if="buyerTierData"
            pills
        >

            <!-- Tab: Account -->
            <b-tab active>
                <template #title>
                    <feather-icon
                        icon="UserIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Account</span>
                </template>
                <buyer-tier-edit-tab-account
                    :buyer-tier-data="buyerTierData"
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
                <buyer-tier-edit-tab-information
                    :buyer-tier-data="buyerTierData"
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
    import buyerTierStoreModule from '../buyerTierStoreModule'
    import BuyerTierEditTabAccount from './BuyerTierEditTabAccount.vue'
    import BuyerTierEditTabInformation from './BuyerTierEditTabInformation.vue'
    import BuyerTierEditTabSocial from './BuyerTierEditTabSocial.vue'

    export default {
        components: {
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,

            BuyerTierEditTabAccount,
            BuyerTierEditTabInformation,
        },

        setup() {

            const buyerTierData = ref(null)

            const BUYERTIER_APP_STORE_MODULE_NAME = 'app-buyer-tier'

            // Register module
            if (!store.hasModule(BUYERTIER_APP_STORE_MODULE_NAME)) store.registerModule(BUYERTIER_APP_STORE_MODULE_NAME, buyerTierStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(BUYERTIER_APP_STORE_MODULE_NAME)) store.unregisterModule(BUYERTIER_APP_STORE_MODULE_NAME)
            })


            store.dispatch('app-buyer-tier/fetchBuyerTier', { id: router.currentRoute.params.id })
                .then(response => { buyerTierData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        buyerTierData.value = undefined
                    }
                })





            return {
                buyerTierData,
            }
        },
    }
</script>

<style>

</style>
