<template>
    <component :is="offerData === undefined ? 'div' : 'b-card'">

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="offerData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching buyer data
            </h4>
            <div class="alert-body">
                No buyer found with this Offer id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-offer-list'}"
                >
                    Offer List
                </b-link>
                for other Offer.
            </div>
        </b-alert>

        <b-tabs
            v-if="offerData"
            pills
        >

<!--             Tab: Account-->
            <b-tab active>
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Offer Details</span>
                </template>
                <offer-tab-account

                    :offer-data="offerData"
                    :internal-options="internalOptions"
                    :category-options="categoryOptions"
                    :conversion-action-options="conversionActionOptions"
                    :conversion-type-options="conversionTypeOptions"
                    :privacy-level-options="privacyLevelOptions"
                    :geo-options="geoOptions"
                    :status-options="statusOptions"
                    class="mt-2 pt-75"
                />
            </b-tab>

            <!-- Tab: Lander -->
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Landing Pages</span>
                </template>
                <lander-tab-information class="mt-2 pt-75"
                                        :offer-data="offerData"
                />
            </b-tab>

            <!-- Tab: Payout -->
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Payouts</span>
                </template>
                <payout-tab-information class="mt-2 pt-75"
                                            :offer-data="offerData"
                />
            </b-tab>
<!---->
            <!-- Tab: Caps -->
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Caps</span>
                </template>
                <caps-tab-information class="mt-2 pt-75"
                                          :offer-data="offerData"
                />
            </b-tab>
<!---->
            <!-- Tab: Tracking -->
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Tracking</span>
                </template>
                <tracking-tab-information class="mt-2 pt-75"
                                              :offer-data="offerData"
                />
            </b-tab>
<!---->
            <!-- Tab: Target Groups -->
            <b-tab>
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Targeting</span>
                </template>
                <targeting-tab-information class="mt-2 pt-75"
                                               :offer-data="offerData"
                                               :status-options="statusOptions"
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
    import offerStoreModule from '../OfferStoreModule'
    import OfferTabAccount from './OfferTabAccount.vue'
    import OfferTabInformation from './OfferTabInformation.vue'
    import LanderTabInformation from './LanderTabInformation.vue'
    import PayoutTabInformation from "./PayoutTabInformation";
    import CapsTabInformation from "./CapsTabInformation";
    import TrackingTabInformation from "./TrackingTabInformation";
    import TargetingTabInformation from "./TargetingTabInformation";


    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import useOffersList from '../offer-list/useOfferList'
    import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'


    export default {
        components: {
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,

            OfferTabAccount,
            OfferTabInformation,
            LanderTabInformation,
            PayoutTabInformation,
            CapsTabInformation,
            TrackingTabInformation,
            TargetingTabInformation,

            ToastificationContent,
        },

        setup() {
            const offerData = ref(null)
            const OFFER = 'app-offer'

            // const offerData = ref(JSON.parse(JSON.stringify(offerDataBlank)))


            // const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
            //     // eslint-disable-next-line no-param-reassign
            //     props.offerData.avatar = base64
            // })
            // const offerData = ref(null)


            // Register module
            if (!store.hasModule(OFFER)) store.registerModule(OFFER, offerStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(OFFER)) store.unregisterModule(OFFER)
            })


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
                { label: 'CPA', value: 1 },
                { label: 'CPL', value: 2 },
                { label: 'CPS', value: 3 },
                { label: 'CPI', value: 4 },
            ]
            const privacyLevelOptions = [
                { label: 'Public', value: 'Public' },
                { label: 'Private', value: 'Private' },
            ]



            store.dispatch('app-offer/fetchOffer', { id: router.currentRoute.params.id })
                .then(response => { offerData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        offerData.value = undefined
                    }
                })



            return {
                offerData,
                internalOptions,
                categoryOptions,
                geoOptions,
                conversionActionOptions,
                conversionTypeOptions,
                privacyLevelOptions,
                // resolveOfferRoleVariant,
                statusOptions,

                // inputImageRenderer,
                ToastificationContent,
                // toast,

            }
        },
    }
</script>

<style>

</style>
