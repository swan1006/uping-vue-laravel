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
                    <label>AFF ID</label>
                    <b-form-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="affIdFilter"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:affIdFilter', val)"
                    >
                        <option value="-1" selected>Select AFF ID</option>
                        <option v-for="option in filterData.vendor_ids" :key="option.vid" :value="option.vid">
                            {{ option.vid }}
                        </option>
                    </b-form-select>
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>SUB ID</label>
                    <b-form-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="subIdFilter"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:subIdFilter', val)"
                    >
                        <option value="-1" selected>Select Sub ID</option>
                        <option v-for="option in filterData.sub_ids" :key="option.subid" :value="option.subid">
                            {{ option.subid }}
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
                        <option value="-1" selected>Select Tier</option>
                        <option v-for="option in filterData.tier_ids" :key="option.tier" :value="option.tier">
                            {{ option.tier }}
                        </option>
                    </b-form-select>
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Vendor Price</label>
                    <b-form-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="vidLeadPriceFilter"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:vidLeadPriceFilter', val)"
                    >
                        <option value="-1" selected>Select Price</option>
                        <option v-for="option in filterData.vidLeadPrice_ids" :key="option.vidLeadPrice" :value="option.vidLeadPrice">
                            {{ '£' + option.vidLeadPrice }}
                        </option>
                    </b-form-select>
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Buyer Price</label>
                    <b-form-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="buyerLeadPriceFilter"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:buyerLeadPriceFilter', val)"
                    >
                        <option value="-1" selected>Select Price</option>
                        <option v-for="option in filterData.buyerLeadPrice_ids" :key="option.buyerLeadPrice" :value="option.buyerLeadPrice">
                            {{ '£'+ option.buyerLeadPrice }}
                        </option>
                    </b-form-select>
                </b-col>
<!--                <b-col-->
<!--                    cols="12"-->
<!--                    md="3"-->
<!--                    class="mb-md-0 mb-2"-->
<!--                >-->
<!--                    <label>Lead Quality</label>-->
<!--                    <v-select-->
<!--                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"-->
<!--                        :value="planFilter"-->
<!--                        :options="planOptions"-->
<!--                        class="w-100"-->
<!--                        :reduce="val => val.value"-->
<!--                        @input="(val) => $emit('update:planFilter', val)"-->
<!--                    />-->
<!--                </b-col>-->
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Redirection</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="redirectionFilter"
                        :options="redirectionOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:redirectionFilter', val)"
                    />
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
    import { BCard, BCardHeader, BCardBody, BRow, BCol, BFormSelect } from 'bootstrap-vue'
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BCard,
            BCardHeader,
            BCardBody,
            BFormSelect,
            vSelect,
        },

        props: {
            affIdFilter: {
                type: [Number, null],
                default: null,
            },
            subIdFilter: {
                type: [String, null],
                default: null,
            },
            tierFilter: {
                type: [String, null],
                default: null,
            },
            vidLeadPriceFilter: {
                type: [Number, null],
                default: null,
            },
            buyerLeadPriceFilter: {
                type: [Number, null],
                default: null,
            },
            qualityScoreFilter: {
                type: [Number, null],
                default: null,
            },
            statusFilter: {
                type: [Number, null],
                default: null,
            },
            redirectionFilter: {
                type: [Number, null],
                default: null,
            },
            filterData: {
                type: [Object, null],
                required: true,
            },

            // affIdFilter,
            // subIdFilter,
            // tierFilter,
            // vidLeadPriceFilter,
            // buyerLeadPriceFilter,
            // qualityScoreFilter,
            // statusFilter,

            // affIdOptions: {
            //     type: Array,
            // },
            // subId: {
            //     type: Array,
            // },
            // affIdOptions: {
            //     type: Array,
            // },

            statusOptions: {
                type: Array,
                required: true,
            },
            redirectionOptions: {
                type: Array,
                required: true,
            },
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
