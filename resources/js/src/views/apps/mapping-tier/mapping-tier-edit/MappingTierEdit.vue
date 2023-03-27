<template>
    <component :is="mappingTierData === undefined ? 'div' : 'b-card'">

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="mappingTierData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching Tier List data
            </h4>
            <div class="alert-body">
                No user found with this user id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-buyer-tier-list'}"
                >
                    MappingTier List
                </b-link>
                for other buyer-tier.
            </div>
        </b-alert>

        <b-tabs
            v-if="mappingTierData"
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
                <mapping-tier-edit-tab-account
                    :mapping-tier-data="mappingTierData"
                    class="mt-2 pt-75"
                />
            </b-tab>

            <!-- Tab: Information -->
<!--            <b-tab>-->
<!--                <template #title>-->
<!--                    <feather-icon-->
<!--                        icon="InfoIcon"-->
<!--                        size="16"-->
<!--                        class="mr-0 mr-sm-50"-->
<!--                    />-->
<!--                    <span class="d-none d-sm-inline">Information</span>-->
<!--                </template>-->
<!--                <mapping-tier-edit-tab-information-->
<!--                    :mapping-tier-data="mappingTierData"-->
<!--                    class="mt-2 pt-75"-->
<!--                />-->
<!--            </b-tab>-->



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
    import mappingTierStoreModule from '../mappingTierStoreModule'
    import MappingTierEditTabAccount from './MappingTierEditTabAccount.vue'
    import MappingTierEditTabInformation from './MappingTierEditTabInformation.vue'

    export default {
        components: {
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,

            MappingTierEditTabAccount,
            MappingTierEditTabInformation,
        },

        setup() {

            const mappingTierData = ref(null)

            const MAPPING_TIER = 'app-mapping-tier'

            // Register module
            if (!store.hasModule(MAPPING_TIER)) store.registerModule(MAPPING_TIER, mappingTierStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(MAPPING_TIER)) store.unregisterModule(MAPPING_TIER)
            })


            store.dispatch('app-mapping-tier/fetchMappingTier', { id: router.currentRoute.params.id })
                .then(response => {
                    mappingTierData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        mappingTierData.value = undefined
                    }
                })




            return {
                mappingTierData,
            }
        },
    }
</script>

<style>

</style>
