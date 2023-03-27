<template>
    <b-card>

        <b-row>

            <!-- User Info: Left col -->


            <b-col
                cols="21"
                xl="6"
                class="d-flex justify-content-between flex-column"
            >
                <!-- User Stats -->
                <div class="d-flex align-items-center mt-2">
                    <div class="d-flex align-items-center mr-2">
                        <b-avatar
                            variant="light-primary"
                            rounded
                        >
                            <feather-icon
                                icon="CalenderSignIcon"
                                size="18"
                            />
                        </b-avatar>
                        <div class="ml-1">
                            <h5 class="mb-0">
                                <!--                                {{ (new Date((buyerData.buyer.created_at)).toLocaleDateString('en-US')) }}-->
                                Active Tiers
                            </h5>
                            <!--                            <small>Date Joined</small>-->
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
<!--                        <th class="pb-50">-->
<!--                            <feather-icon-->
<!--                                icon="UserIcon"-->
<!--                                class="mr-75"-->
<!--                            />-->
<!--                            <span class="font-weight-bold">Tiers</span>-->
<!--                        </th>-->


                        <li class="badge-light-primary mb-1" v-for="item in buyerData.buyer.tiers">
                                <feather-icon
                                    icon="UserIcon"
                                    class="mr-75"
                                />
                        <span class="font-weight-bold">
                        <b-badge variant="light-primary">
                            {{ item.buyername}} - £{{ item.tier_price}}
                        </b-badge>
                            </span>
                        </li>

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
    import {avatarText} from '@core/utils/filter'
    import useBuyersList from '../buyer-list/useBuyerList'

    export default {
        components: {
            BCard, BButton, BRow, BCol, BAvatar, BBadge
        },
        props: {
            buyerData: {
                type: Object,
                required: true,
            },
        },
        setup() {
            const {resolveBuyerRoleVariant, goBack} = useBuyersList()
            return {
                avatarText,
                resolveBuyerRoleVariant,
                goBack,
            }
        },
    }
</script>

<style>

</style>
