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
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Lead Type</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="leadTypeFilter"
                        :options="leadTypeOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:leadTypeFilter', val)"
                    />
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Buyer ID</label>
                    <b-form-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="buyerFilter"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:buyerFilter', val)"
                    >
                        <option :value="null" selected>Select Buyer</option>
                        <option v-for="option in filterTierData.buyer_ids" :key="option.id" :value="option.id">
                            {{ option.name }}
                        </option>
                    </b-form-select>
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>TIER ID</label>
                    <b-form-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="tierFilter"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:tierFilter', val)"
                    >
                        <option :value="null" selected>Select Tier</option>
                        <option v-for="option in filterTierData.tier_ids" :key="option.tier" :value="option.id">
                            {{ option.buyername }}
                        </option>
                    </b-form-select>
                </b-col>


                <b-col
                    cols="12"
                    md="3"
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
    import {BCard, BCardHeader, BCardBody, BRow, BCol, BFormSelect, BFormSelectOption,} from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import {ref} from '@vue/composition-api'
    import store from '@/store'

    export default {
        components: {
            BRow,
            BCol,
            BCard,
            BCardHeader,
            BCardBody,
            vSelect,
            BFormSelect,
            BFormSelectOption,
        },
        props: {
            leadTypeFilter: {
                type: [Number, null],
                default: null,
            },
            tierFilter: {
                type: [Number, null],
                default: null,
            },
            buyerFilter: {
                type: [Number, null],
                default: null,
            },
            statusFilter: {
                type: [Number, null],
                default: null,
            },
            filterTierData: {
                type: Object,
                default: null,
            },
            leadTypeOptions: {
                type: Array,
                required: true,
            },
            statusOptions: {
                type: Array,
                required: true,
            }
        },
        setup(props) {


            return {
                // filterTierData,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
