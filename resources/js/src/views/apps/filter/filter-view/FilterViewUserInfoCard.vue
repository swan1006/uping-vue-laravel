<template>
    <b-card>
        <b-row>

            <!-- BuyerTier Info: Left col -->
            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    md="12"
                    class="d-flex justify-content-between flex-column"

                >


                    <b-table
                        small
                        :fields="fields"
                        :items="singleFilterData.filter.conditions"
                        responsive="sm"
                        :striped="true"
                        :borderless="true"
                    >
                        <!-- A virtual column -->
                        <template #cell(index)="data">
                            {{ data.item }}
                        </template>

                        <!-- A custom formatted column -->


<!--                        &lt;!&ndash; A custom formatted column &ndash;&gt;-->
<!--                        <template #cell(Popularity)="data">-->
<!--                            <b-progress-->
<!--                                :value="data.value.value"-->
<!--                                max="100"-->
<!--                                :variant="data.value.variant"-->
<!--                                striped-->
<!--                            />-->
<!--                        </template>-->

<!--                        <template #cell(order_status)="data">-->
<!--                            <b-badge-->
<!--                                pill-->
<!--                                :variant="data.value.variant"-->
<!--                            >-->
<!--                                {{ data.value.status }}-->
<!--                            </b-badge>-->
<!--                        </template>-->

                        <!-- A virtual composite column -->
<!--                        <template #cell(price)="data">-->
<!--                            {{ '$'+data.value }}-->
<!--                        </template>-->

<!--                        &lt;!&ndash; Optional default data cell scoped slot &ndash;&gt;-->
<!--                        <template #cell()="data">-->
<!--                            {{ data.value }}-->
<!--                        </template>-->
                    </b-table>

                </b-col>
            </b-row>

<!--            <b-col-->
<!--                cols="12"-->
<!--                xl="6"-->
<!--                class="d-flex justify-content-between flex-column"-->
<!--            >-->
<!--                &lt;!&ndash; Buyer Avatar & Action Buttons &ndash;&gt;-->
<!--                <div class="d-flex justify-content-start">-->

<!--                    <div class="d-flex flex-column ml-1">-->
<!--                        <div class="mb-1">-->
<!--                            <h4 class="mb-0">-->
<!--&lt;!&ndash;                                {{ filterData.filter.filter_type }}&ndash;&gt;-->
<!--                            </h4>-->
<!--&lt;!&ndash;                            <span class="card-text">{{ filterData.filter.tier_price }}</span>&ndash;&gt;-->
<!--                        </div>-->
<!--                        <div class="d-flex flex-wrap">-->
<!--                            <b-button-->
<!--                                variant="outline-primary"-->
<!--                                class="ml-1"-->
<!--                                @click="goBack"-->
<!--                            >-->
<!--                                Back-->
<!--                            </b-button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->



<!--            </b-col>-->

<!--            &lt;!&ndash; Right Col: Table &ndash;&gt;-->


<!--            <b-col-->
<!--                cols="12"-->
<!--                xl="6"-->
<!--            >-->

<!--                <table class="mt-2 mt-xl-0 w-100">-->

<!--                    <tr>-->
<!--                        <th class="pb-50">-->
<!--                            <feather-icon-->
<!--                                icon="CheckIcon"-->
<!--                                class="mr-75"-->
<!--                            />-->
<!--                            <span class="font-weight-bold">Filter ID</span>-->
<!--                        </th>-->
<!--                        <td class="pb-50 text-capitalize">-->
<!--                            <b-badge variant="light-primary">-->
<!--                                {{ singleFilterData.filter.id }}-->
<!--                            </b-badge>-->



<!--                        </td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <th class="pb-50">-->
<!--                            <feather-icon-->
<!--                                icon="CheckIcon"-->
<!--                                class="mr-75"-->
<!--                            />-->
<!--                            <span class="font-weight-bold">Filter Type</span>-->
<!--                        </th>-->
<!--                        <td class="pb-50 text-capitalize">-->
<!--                            <b-badge variant="light-primary">-->
<!--                                {{ singleFilterData.filter.filter_type }}-->
<!--                            </b-badge>-->


<!--                        </td>-->
<!--                    </tr>-->

<!--                    <tr>-->
<!--                        <th class="pb-50">-->
<!--                            <feather-icon-->
<!--                                icon="CheckIcon"-->
<!--                                class="mr-75"-->
<!--                            />-->
<!--                            <span class="font-weight-bold">Conditions</span>-->
<!--                        </th>-->
<!--                        <td class="pb-50 text-capitalize">-->


                            <pre class="text-success bg-black">
                                <code>
                                        {{singleFilterData.filter.conditions}}
                                </code>
                            </pre>


<!--                        </td>-->
<!--                    </tr>-->

<!--                </table>-->
<!--            </b-col>-->


        </b-row>
    </b-card>


</template>



<script>
    import {
        BCard, BButton, BAvatar, BRow, BCol,  BTable, BProgress, BBadge
    } from 'bootstrap-vue'
    import { avatarText } from '@core/utils/filter'
    import useFiltersList from '../filter-list/useFilterList'
    import {onUnmounted} from "@vue/composition-api";
    import filterStoreModule from '../filterStoreModule';
    import store from '@/store';


    export default {
        components: {
            BCard, BButton, BRow, BCol, BAvatar, BTable, BProgress, BBadge
        },
        props: {
            singleFilterData: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                fields: [
                    // A virtual column that doesn't exist in items
                    'index',
                    // A column that needs custom formatting
                    { key: 'name', label: 'Name' },
                    'Category',
                    // A regular column

                ],
                items: [
                    {
                        name: { first: 'Fitbit', last: 'Activity Tracker' },
                        Category: 'Fitness',
                        order_status: { status: 'Delivered', variant: 'success' },
                        Popularity: { value: 50, variant: 'success' },
                    },
                    {
                        name: { first: 'Fitbit ', last: 'Flex Wireless Activity' },
                        Category: 'Fitness',
                        order_status: { status: 'Pending', variant: 'primary' },
                    },

                ],
            }
        },
        setup(props) {



            const FILTERS = 'app-filters'

            // Register module
            if (!store.hasModule(FILTERS)) store.registerModule(FILTERS, filterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(FILTERS)) store.unregisterModule(FILTERS)
            })


            function goBack() {
                history.back()
            }



            return {
                goBack,
            }
        },
    }
</script>

<style>

</style>
