<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">
            <feather-icon
                icon="SendIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Targeting Information
            </h4>
        </div>

        <!-- Form: Personal Info Form -->
        <b-form class="mt-1">
            <b-row>

                <!-- Field: Target Group Name -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Target Group Name"
                        label-for="target_group_name"
                    >
                        <b-form-input
                            id="target_group_name"
                            v-model="offerData.offer.target_group.target_group_name"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row>
                <!-- Field: Target Group All Devices -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="All Devices"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="offerData.offer.target_group.all_devices"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Target Group target_devices -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Target Devices"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="offerData.offer.target_group.target_devices"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>



            </b-row>

            <!-- Header: Personal Info -->
            <div class="d-flex mt-2">
                <feather-icon
                    icon="MapPinIcon"
                    size="19"
                />
                <h4 class="mb-0 ml-50">
                    Demograhic Information
                </h4>
            </div>

            <!-- Form: Personal Info Form -->
            <b-row class="mt-1">


                <!-- Field: Countries -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Countries"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="offerData.offer.target_group.countries"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Regions -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Regions"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="offerData.offer.target_group.regions"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Cities -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Cities"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="offerData.offer.target_group.cities"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Regions -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Regions"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="offerData.offer.target_group.regions"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Connection Type -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Connection Type"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="offerData.offer.target_group.connection_type"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>


            </b-row>


        </b-form>
    </div>
</template>

<script>
    import { BRow, BCol, BForm, BFormGroup, BFormInput, BFormRadioGroup, BFormCheckboxGroup, BButton } from 'bootstrap-vue'
    import flatPickr from 'vue-flatpickr-component'
    import { ref } from '@vue/composition-api'
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BForm,
            BFormGroup,
            flatPickr,
            BFormInput,
            vSelect,
            BFormRadioGroup,
            BFormCheckboxGroup,
            BButton,
        },
        props: {
            offerData: {
                type: Object,
                required:true,
            },
            statusOptions: {
                type: Array,
                required:true,
            }
        },
        setup(props) {


            return {
                // offerData
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
