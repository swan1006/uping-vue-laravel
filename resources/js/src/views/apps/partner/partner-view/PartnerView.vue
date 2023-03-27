<template>
    <div>

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="partnerData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching user data
            </h4>
            <div class="alert-body">
                No user found with this user id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-users-list'}"
                >
                    User List
                </b-link>
                for other users.
            </div>
        </b-alert>

        <template v-if="partnerData">
            <!-- First Row -->
            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                >
                    <partner-view-user-info-card :partner-data="partnerData" />
                </b-col>

            </b-row>

            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                >
                    <partner-company-user-info-card :partner-data="partnerData" />

                </b-col>
                <b-col
                    cols="12"
                    lg="6"
                >
                </b-col>
            </b-row>

        </template>

        <partner-invoice-list/>

    </div>
</template>

<script>
    import store from '@/store'
    import router from '@/router'
    import { ref, onUnmounted } from '@vue/composition-api'
    import {
        BRow, BCol, BAlert, BLink, BBadge
    } from 'bootstrap-vue'
    import PartnerInvoiceList from '@/views/apps/invoice/partner-invoice-list/PartnerInvoiceList.vue'
    import partnerStoreModule from '../PartnerStoreModule'
    import PartnerViewUserInfoCard from './PartnerViewUserInfoCard.vue'
    import PartnerCompanyUserInfoCard from './PartnerCompanyUserInfoCard.vue'
    import PartnerViewUserPlanCard from './PartnerViewUserPlanCard.vue'
    import PartnerViewUserTimelineCard from './PartnerViewUserTimelineCard.vue'
    import PartnerViewUserPermissionsCard from './PartnerViewUserPermissionsCard.vue'

    export default {
        components: {
            BRow,
            BCol,
            BAlert,
            BLink,
            BBadge,

            // Local Components
            PartnerViewUserInfoCard,
            PartnerCompanyUserInfoCard,
            PartnerViewUserPlanCard,
            PartnerViewUserTimelineCard,
            PartnerViewUserPermissionsCard,

            PartnerInvoiceList,
        },
        setup() {
            const partnerData = ref(null)

            const PARTNER_APP_STORE_MODULE_NAME = 'app-partner'

            // Register module
            if (!store.hasModule(PARTNER_APP_STORE_MODULE_NAME)) store.registerModule(PARTNER_APP_STORE_MODULE_NAME, partnerStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(PARTNER_APP_STORE_MODULE_NAME)) store.unregisterModule(PARTNER_APP_STORE_MODULE_NAME)
            })

            store.dispatch('app-partner/fetchPartner', { id: router.currentRoute.params.id })
                .then(response => { partnerData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        partnerData.value = undefined
                    }
                })

            return {
                partnerData,
            }
        },
    }
</script>

<style>

</style>
