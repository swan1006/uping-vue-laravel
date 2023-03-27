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
            affSubFilter: {
                type: [Number, null],
                default: null,
            },
            affSub2Filter: {
                type: [Number, null],
                default: null,
            },

            affSub3Filter: {
                type: [Number, null],
                default: null,
            },

            affSub4Filter: {
                type: [Number, null],
                default: null,
            },

            affSub5Filter: {
                type: [Number, null],
                default: null,
            },
            statusFilter: {
                type: [Number, null],
                default: null,
            },

            filterData: {
                type: [Object, null],
                required: true,
            },


            statusOptions: {
                type: Array,
                required: true,
            },
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
