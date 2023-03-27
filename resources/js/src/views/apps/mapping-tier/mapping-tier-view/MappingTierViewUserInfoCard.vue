<template>
    <b-card
        >

        <b-row>

            <!-- MappingTier Info: Left col -->


            <b-col
                cols="21"
                xl="6"
                class="d-flex justify-content-between flex-column"
            >
                <!-- Buyer Avatar & Action Buttons -->
                <div class="d-flex justify-content-start">
                    <b-avatar
                        :src="mappingTierData.avatar"
                        :variant="`light-${resolveMappingTierRoleVariant(mappingTierData.role)}`"
                        size="104px"
                        rounded
                    />
                    <div class="d-flex flex-column ml-1">
                        <div class="mb-1">
                            <h4 class="mb-0">
                                {{ mappingTierData.mapping.buyer_setup[0].buyername }}
                            </h4>
                            <span class="card-text">Mapping ID: {{ $route.params.id }}</span>
                        </div>
                        <div class="d-flex flex-wrap">
                            <b-button
                                :to="{ name: 'apps-mapping-tier-edit', params: { id:  $route.params.id } }"
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
                                {{ mappingTierData.mapping.buyer_setup[0].buyername }}
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
                                £   {{ mappingTierData.mapping.buyer_setup[0].tier_price }}
                            </b-badge>


                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="CheckIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Vendor ID</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge variant="light-primary">
                                  {{ mappingTierData.mapping.partner[0].vendor_id }}
                            </b-badge>


                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="CheckIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Buyer Name</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge variant="light-primary">
                                  {{ mappingTierData.mapping.buyer[0].name }}
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
                                <span v-if="mappingTierData.mapping.buyer_setup[0].model_type === '1'">CPA</span>
                                <span  v-else-if="mappingTierData.mapping.buyer_setup[0].model_type === '2'">CPL</span>
                                <span  v-else-if="mappingTierData.mapping.buyer_setup[0].model_type === '3'">CPF</span>
                                <span  v-else-if="mappingTierData.mapping.buyer_setup[0].model_type === '0'">Hybrid</span>
                            </b-badge>
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
                                <b-avatar v-if="mappingTierData.mapping.mapping.leadtype === '1'"
                                          size="sm"
                                          :src="require('@/assets/images/avatars/flag-uk-icon.png')"
                                />
                                <b-avatar v-else-if="mappingTierData.mapping.mapping.leadtype === '2'"
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
    import useMappingTiersList from '../mapping-tier-list/useMappingTierList'
    import {onUnmounted} from "@vue/composition-api";
    import mappingTierStoreModule from '../mappingTierStoreModule';
    import store from '@/store';


    export default {
        components: {
            BCard, BButton, BRow, BCol, BAvatar, BBadge
        },
        props: {
            mappingTierData: {
                type: Object,
                required: true,
            },
        },
        setup(props) {

            const { resolveMappingTierRoleVariant, resolveMappingTierStatusVariant, goBack } = useMappingTiersList()


            const MAPPING_TIER = 'app-mapping-tier'

            // Register module
            if (!store.hasModule(MAPPING_TIER)) store.registerModule(MAPPING_TIER, mappingTierStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(MAPPING_TIER)) store.unregisterModule(MAPPING_TIER)
            })





            return {
                avatarText,
                resolveMappingTierRoleVariant,
                resolveMappingTierStatusVariant,
                goBack,
            }
        },
    }
</script>

<style>

</style>
