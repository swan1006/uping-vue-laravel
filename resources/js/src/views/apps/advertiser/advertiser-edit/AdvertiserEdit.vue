<template>
    <component :is="advertiserData === undefined ? 'div' : 'b-card'">

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="advertiserData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching user data
            </h4>
            <div class="alert-body">
                No user found with this advertiser id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-users-list'}"
                >
                    Advertiser List
                </b-link>
                for other advertisers.
            </div>
        </b-alert>

        <b-tabs
            v-if="advertiserData"
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
                    <span class="d-none d-sm-inline">Advertiser</span>
                </template>
                <advertiser-edit-tab-account
                    :advertiser-data="advertiserData"
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
                    <span class="d-none d-sm-inline">Company</span>
                </template>
                <advertiser-edit-tab-information
                    :advertiser-data="advertiserData"
                    class="mt-2 pt-75"
                />
            </b-tab>

            <!-- Tab: Information -->
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="UserCheckIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Active Offers</span>
                </template>
                <advertiser-offer-list
                    :advertiser-data="advertiserData"
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
    import advertiserStoreModule from '../advertiserStoreModule'
    import AdvertiserEditTabAccount from './AdvertiserEditTabAccount.vue'
    import AdvertiserEditTabInformation from './AdvertiserEditTabInformation.vue'
    import AdvertiserOfferList from '@/views/apps/advertiser-offer/advertiser-offer-list/AdvertiserOfferList.vue'

    export default {
        components: {
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,

            AdvertiserEditTabAccount,
            AdvertiserEditTabInformation,
            AdvertiserOfferList,
        },

        setup() {

            const advertiserData = ref(null)

            const ADVERTISERS = 'app-advertisers'

            // Register module
            if (!store.hasModule(ADVERTISERS)) store.registerModule(ADVERTISERS, advertiserStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(ADVERTISERS)) store.unregisterModule(ADVERTISERS)
            })


            store.dispatch('app-advertisers/fetchAdvertiser', { id: router.currentRoute.params.id })
                .then(response => { advertiserData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        advertiserData.value = undefined
                    }
                })





            return {
                advertiserData,
            }
        },
    }
</script>

<style>

</style>
