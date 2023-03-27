<template>
    <b-card
        >

        <b-row>

            <!-- BuyerTier Info: Left col -->


            <b-col
                cols="21"
                xl="6"
                class="d-flex justify-content-between flex-column"
            >
                <!-- Buyer Avatar & Action Buttons -->
                <div class="d-flex justify-content-start">
                    <b-avatar
                        :src="buyerTierData.avatar"
                        :variant="`light-${resolveBuyerTierRoleVariant(buyerTierData.role)}`"
                        size="104px"
                        rounded
                    />
                    <div class="d-flex flex-column ml-1">
                        <div class="mb-1">
                            <h4 class="mb-0">
                                {{ buyerTierData.buyertier.buyername }}
                            </h4>
                            <span class="card-text">{{ buyerTierData.buyername }}</span>
                        </div>
                        <div class="d-flex flex-wrap">
                            <b-button
                                :to="{ name: 'apps-buyer-tier-edit', params: { id: buyerTierData.buyertier.id } }"
                                variant="primary"
                            >
                                Edit
                            </b-button>
                            <b-button
                                variant="outline-primary"
                                class="ml-1"
                                @click="goBack"
                            >
                                Back
                            </b-button>
                        </div>
                    </div>
                </div>

                <!-- Buyer Stats -->
                <div class="d-flex align-items-center mt-2">
                    <div class="d-flex align-items-center mr-2">
                        <b-avatar
                            variant="light-primary"
                            rounded
                        >
                            <feather-icon
                                icon="DollarSignIcon"
                                size="18"
                            />
                        </b-avatar>
                        <div class="ml-1">
                            <h5 class="mb-0">
                                £5500
                            </h5>
                            <small>Monthly Sales</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <b-avatar
                            variant="light-success"
                            rounded
                        >
                            <feather-icon
                                icon="TrendingUpIcon"
                                size="18"
                            />
                        </b-avatar>
                        <div class="ml-1">
                            <h5 class="mb-0">
                                £99.87k
                            </h5>
                            <small>Annual Profit</small>
                        </div>
                    </div>
                </div>
            </b-col>

            <!-- Right Col: Table -->
            <b-col
                cols="12"
                xl="6"
            >
                <table class="mt-2 mt-xl-0 w-100">

                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="CheckIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Tier ID</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge variant="light-primary">
                                TIER_1234
                            </b-badge>


                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="CheckIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Tier Price</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge variant="light-primary">
                                £ {{ buyerTierData.buyertier.tier_price }}
                            </b-badge>


                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Model Type</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge variant="light-primary">
                                {{buyerTierData.buyertier.model_type}}

                            </b-badge>
                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Mode</span>
                        </th>
                        <td class="pb-50 text-capitalize">

                            <b-badge variant="light-success" v-if="buyerTierData.buyertier.mode === 1">
                                Active
                            </b-badge>
                            <b-badge variant="light-info" v-if="buyerTierData.buyertier.mode === 2">
                                Pending
                            </b-badge>

                            <b-badge variant="light-warning" v-if="buyerTierData.buyertier.mode === 0">
                                Inactive
                            </b-badge>
<!--                            <b-badge variant="light-primary">-->
<!--&lt;!&ndash;                                <span  v-if=" === 1">Active</span>&ndash;&gt;-->
<!--                                <span v-else-if="buyerTierData.buyertier.mode === 0">Inactive</span>-->
<!--                                <span v-else-if="buyerTierData.buyertier.mode === 2">Test</span>-->
<!--                            </b-badge>-->

                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Lead Type</span>
                        </th>
                        <td class="pb-50 text-capitalize">

                            <b-avatar v-if="buyerTierData.buyertier.leadtype === '1'"
                                      size="sm"
                                      :src="require('@/assets/images/avatars/flag-uk-icon.png')"
                            />
                            <b-avatar v-else-if="buyerTierData.buyertier.leadtype === '2'"
                                      size="sm"
                                      :src="require('@/assets/images/avatars/flag-us-icon.png')"
                            />

                        </td>
                    </tr>

                </table>
            </b-col>
        </b-row>
    </b-card>


</template>


<script>
    import {
        BCard, BButton, BAvatar, BRow, BCol, BBadge
    } from 'bootstrap-vue'
    import { avatarText } from '@core/utils/filter'
    import useBuyerTiersList from '../buyer-tier-list/useBuyerTierList'
    import {onUnmounted} from "@vue/composition-api";
    import buyerTierStoreModule from '../buyerTierStoreModule';
    import store from '@/store';


    export default {
        components: {
            BCard, BButton, BRow, BCol, BAvatar, BBadge
        },
        props: {
            buyerTierData: {
                type: Object,
                required: true,
            },
        },
        setup(props) {

            const { resolveBuyerTierRoleVariant, resolveBuyerTierStatusVariant, goBack } = useBuyerTiersList()


            const BUYERTIER_APP_STORE_MODULE_NAME = 'app-buyer-tiers'

            // Register module
            if (!store.hasModule(BUYERTIER_APP_STORE_MODULE_NAME)) store.registerModule(BUYERTIER_APP_STORE_MODULE_NAME, buyerTierStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(BUYERTIER_APP_STORE_MODULE_NAME)) store.unregisterModule(BUYERTIER_APP_STORE_MODULE_NAME)
            })





            return {
                avatarText,
                goBack,
                resolveBuyerTierRoleVariant,
                resolveBuyerTierStatusVariant
            }
        },
    }
</script>

<style>

</style>
