<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">


            <feather-icon
                icon="UserIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Tier Information
            </h4>
        </div>

        <!-- Form: Personal Info Form -->
        <b-form class="mt-1" @submit.prevent="updateBuyerTierForm">
            <b-row>

                <!-- Field: Tier Name -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Tier ID"
                        label-for="buyername"
                    >
                        <b-form-input
                            id="buyername"
                            v-model="buyerTierData.buyertier.buyername"
                            trim
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Tier Price -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Tier Price"
                        label-for="tier_price"
                    >
                        <b-form-input
                            id="tier_price"
                            v-model="buyerTierData.buyertier.tier_price"
                            trim
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
                    Options
                </h4>
            </div>

            <!-- Form: Personal Info Form -->
            <b-row class="mt-1">

                <!-- Field: Status -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Status"
                        label-for="status"
                    >
                        <v-select
                            v-model="buyerTierData.buyertier.status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="status"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Mode -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Mode"
                        label-for="mode"
                    >
                        <v-select
                            v-model="buyerTierData.buyertier.mode"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="modeOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="mode"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Rotate -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Rotate"
                        label-for="rotate"
                    >
                        <v-select
                            v-model="buyerTierData.buyertier.rotate"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="rotateOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="rotate"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Posting Order -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Posting Order"
                        label-for="posting_order"
                    >
                        <v-select
                            v-model="buyerTierData.buyertier.posting_order"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="postingOrderOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="posting_order"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Timeout -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Timeout"
                        label-for="timeout"
                    >
                        <v-select
                            v-model="buyerTierData.buyertier.timeout"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="timeoutOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="timeout"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Model Type -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Model Type"
                        label-for="model_type"
                    >
                        <v-select
                            v-model="buyerTierData.buyertier.model_type"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="modelTypeOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="model_type"
                        />
                    </b-form-group>
                </b-col>


            </b-row>

            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                        type="submit"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                    <b-button
                        variant="outline-primary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                        @click="goBack"
                    >
                        Back
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>

<script>
    import {
        BButton,
        BMedia,
        BAvatar,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
    } from 'bootstrap-vue'
    import {avatarText} from '@core/utils/filter'
    import vSelect from 'vue-select'
    import {useInputImageRenderer} from '@core/comp-functions/forms/form-utils'
    import {ref} from '@vue/composition-api'
    import useBuyerTierList from '../buyer-tier-list/useBuyerTierList'
    import store from '@/store'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import { useToast } from 'vue-toastification/composition'


    export default {
        components: {
            BButton,
            BMedia,
            BAvatar,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            vSelect,
        },
        props: {
            buyerTierData: {
                type: Object,
                required: true,
            },
        },
        setup(props) {
            const {resolveBuyerTierRoleVariant, goBack} = useBuyerTierList()
            const toast = useToast()



            // TODO : API
            const statusOptions = [
                {label: 'Pending', value: 2},
                {label: 'Active', value: 1},
                {label: 'Inactive', value: 0},
            ]
            const rotateOptions = [
                {label: 'Active', value: 1},
                {label: 'Inactive', value: 0},
            ]
            const modeOptions = [
                {label: 'Test', value: 2},
                {label: 'Live', value: 1},
                {label: 'Inactive', value: 0},
            ]
            const timeoutOptions = [
                {label: 55, value: 1},
                {label: 120, value: 2},
                {label: 210, value: 3},
            ]
            const postingOrderOptions = [
                {label: 1, value: 1},
                {label: 2, value: 2},
                {label: 3, value: 3},
            ]
            const modelTypeOptions = [
                {label: 'CPA', value: 1},
                {label: 'CPL', value: 2},
                {label: 'CPF', value: 3},
                {label: 'Hybrid', value: 4},
            ]


            // ? Demo Purpose => Update image on click of update
            const refInputEl = ref(null)
            const previewEl = ref(null)

            const {inputImageRenderer} = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign
                props.buyerTierData.avatar = base64
            })


            function updateBuyerTierForm(ev) {
                ev.preventDefault();
                // console.log(ev)
                // debugger
                store.dispatch("app-buyer-tier/updateBuyerTierForm", props.buyerTierData.buyertier)
                    .then((res) => {
                        // console.log(res)
                        // debugger
                        toast({
                            component: ToastificationContent,
                            props: {
                                title:  'Information updated successfully',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                        // loading.value = false;
                        // router.push({
                        //     name: "Dashboard",
                        // });
                    })
                    .catch((error) => {
                        // loading.value = false;
                        toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Error updating Information',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }


            return {
                resolveBuyerTierRoleVariant,
                avatarText,
                modelTypeOptions,
                statusOptions,
                postingOrderOptions,
                timeoutOptions,
                modeOptions,
                rotateOptions,
                //  ? Demo - Update Image on click of update button
                refInputEl,
                previewEl,
                inputImageRenderer,
                updateBuyerTierForm,
                goBack,
                toast,

            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
