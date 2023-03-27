<template>
    <b-card no-body>
        <b-card-header class="pb-50">
            <h5>
                Filters
            </h5>
        </b-card-header>
        <b-card-body>
            <b-row>
                <b-col
                    cols="12"
                    md="4"
                    class="mb-md-0 mb-2"
                >
                    <label>Role</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="buyerTypeFilter"
                        :options="buyerTypeOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:buyerTypeFilter', val)"
                    />
                </b-col>
                <b-col
                    cols="12"
                    md="4"
                    class="mb-md-0 mb-2"
                >
                    <label>Status</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="statusFilter"
                        :options="statusOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:statusFilter', val)"
                    />
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</template>

<script>
    import {BCard, BCardHeader, BCardBody, BRow, BCol} from 'bootstrap-vue'
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BCard,
            BCardHeader,
            BCardBody,
            vSelect,
        },
        props: {
            buyerTypeFilter: {
                type: [String, null],
                default: null,
            },
            statusFilter: {
                type: [Number, null],
                default: null,
            },
            statusOptions: {
                type: Array,
                required: true,
            },

        },
        setup() {
            const buyerTypeOptions = [
                { label: 'Lender', value: 'Lender' },
                { label: 'Broker', value: 'Broker' },
            ]
            return {
                buyerTypeOptions,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
