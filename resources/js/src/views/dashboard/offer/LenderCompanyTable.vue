<template>
    <b-card
        v-if="tableData"
        no-body
        class="card-company-table"
    >
        <b-table
            :items="tableData.dashboard_data.adv_table_data"
            responsive
            :fields="fields"
            class="mb-0"
        >
            <!-- company -->
            <template #cell(company)="data">
                <div class="d-flex align-items-center">
                    <div class="font-weight-bolder">
                        <b-badge class-="light-primary">
                            {{ data.item.title }}
                        </b-badge>
                    </div>
                    <div class="font-small-2 text-muted">
                        <!--              {{ data.item.subtitle }}-->
                    </div>
                </div>
            </template>


            <!-- views -->
            <template #cell(offer)="data">
                <div class="d-flex flex-column">
                    <b-badge>
                        {{ data.item.name }}
                    </b-badge>

<!--                    <span class="font-small-2 text-muted text-nowrap">{{ data.item.viewsub }}</span>-->
                </div>
            </template>

            <!-- views -->
            <template #cell(clicks)="data">
                <div class="d-flex flex-column">
                    <span class="font-weight-bolder mb-25">{{ data.item.clicks }}</span>
<!--                    <span class="font-small-2 text-muted text-nowrap">{{ data.item.viewsub }}</span>-->
                </div>
            </template>
            <!-- views -->
            <template #cell(conversions)="data">
                <div class="d-flex flex-column">
                    <span class="font-weight-bolder mb-25">{{ data.item.conversions }}</span>
<!--                    <span class="font-small-2 text-muted text-nowrap">{{ data.item.viewsub }}</span>-->
                </div>
            </template>


            <!-- revenue -->
            <template #cell(revenue)="data">
                {{ '£'+data.item.revenue }}
            </template>

            <!-- profit -->
            <template #cell(profit)="data">

            <span class="text-success bold">
                 {{ '£'+data.item.revenue }}
            </span>
            </template>



            <!-- sales -->
            <template #cell(ratio)="data">
                <div class="d-flex align-items-center">
                    <span class="font-weight-bolder mr-1">{{ data.item.sales+'%' }}</span>
                    <feather-icon
                        :icon="data.item.loss ? 'TrendingDownIcon':'TrendingUpIcon'"
                        :class="data.item.loss ? 'text-danger':'text-success'"
                    />
                </div>
            </template>
        </b-table>
    </b-card>
</template>

<script>
    import {
        BCard, BTable, BAvatar, BImg, BBadge,
    } from 'bootstrap-vue'

    export default {
        components: {
            BCard,
            BTable,
            BAvatar,
            BImg,
            BBadge
        },
        props: {
            tableData: {
                type: Object,
                default: () => [],
            },
        },

        data() {
            return {
                fields: [
                    { key: 'offer', label: 'OFFER' },
                    { key: 'clicks', label: 'CLICKS' },
                    { key: 'conversions', label: 'CONVERSIONS' },
                    { key: 'revenue', label: 'REVENUE' },
                    { key: 'profit', label: 'PROFIT' },
                ],
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import '~@core/scss/base/bootstrap-extended/include';
    @import '~@core/scss/base/components/variables-dark';

    .card-company-table ::v-deep td .b-avatar.badge-light-company {
        .dark-layout & {
            background: $theme-dark-body-bg !important;
        }
    }
</style>
