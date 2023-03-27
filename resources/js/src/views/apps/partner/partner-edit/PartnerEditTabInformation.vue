<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">
            <feather-icon
                icon="BuyerIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Company Information
            </h4>
        </div>

        <!-- Form: Personal Info Form -->
        <b-form class="mt-1"
                @submit.prevent="updatePartnerCompanyForm">
            <b-row>

                <!-- Field: Join Date -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Join Date"
                        label-for="birth-date"
                    >
                        <flat-pickr
                            v-model="partnerData.partner[0].company.created_at"
                            class="form-control"
                            :config="{ dateFormat: 'd-m-Y'}"
                            placeholder="DD-MM-YYYY"
                            disabled
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Phone -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Mobile"
                        label-for="mobile"
                    >
                        <b-form-input
                            id="mobile"
                            v-model="partnerData.partner[0].company.phone"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Website -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Website"
                        label-for="website"
                    >
                        <b-form-input
                            id="website"
                            v-model="partnerData.partner[0].company.website"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Language -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="IM/Skype"
                        label-for="skype"
                    >
                        <b-form-input
                            id="skype"
                            v-model="partnerData.partner[0].company.skype"
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
                    Address
                </h4>
            </div>

            <!-- Form: Personal Info Form -->
            <b-row class="mt-1">

                <!-- Field: Address Line 1 -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Address Line 1"
                        label-for="address1"
                    >
                        <b-form-input
                            id="address1"
                            v-model="partnerData.partner[0].company.address1"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Address Line 2 -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Address Line 2"
                        label-for="address2"
                    >
                        <b-form-input
                            id="address2"
                            v-model="partnerData.partner[0].company.address2"
                            placeholder="Los Santos"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Postcode -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Postcode"
                        label-for="postcode"
                    >
                        <b-form-input
                            id="postcode"
                            v-model="partnerData.partner[0].company.postcode"
                            placeholder="597626"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: City -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="City"
                        label-for="city"
                    >
                        <b-form-input
                            id="city"
                            v-model="partnerData.partner[0].company.city"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: State -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="State"
                        label-for="state"
                    >
                        <b-form-input
                            id="state"
                            v-model="partnerData.partner[0].company.state"
                            placeholder="Manhattan"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Country -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Country"
                        label-for="country"
                    >
                        <b-form-input
                            id="country"
                            v-model="partnerData.partner[0].company.country"
                            placeholder="United States"
                        />
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        type="submit"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                    <b-button
                        variant="outline-primary"
                        class="ml-1"
                        @click="goBack"
                    >
                        <span class="d-none d-sm-inline">Back</span>
                        <feather-icon
                            icon="TrashIcon"
                            class="d-inline d-sm-none"
                        />
                    </b-button>

                </b-col>
            </b-row>
        </b-form>
    </div>
</template>

<script>
    import {
        BRow,
        BCol,
        BForm,
        BFormGroup,
        BFormInput,
        BFormRadioGroup,
        BFormCheckboxGroup,
        BButton
    } from 'bootstrap-vue'
    import flatPickr from 'vue-flatpickr-component'
    import {ref} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import store from '@/store'
    import usePartnersList from '../partner-list/usePartnerList'
    import PartnerStoreModule from '../PartnerStoreModule'


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
            ToastificationContent

        },
        props: {
            partnerData: {
                type: Object,
                required: true,
            },
        },
        methods: {
            updatePartnerCompanyForm(ev) {
                ev.preventDefault();

                // loading.value = true;

                // console.log(props.buyerData.user)
                // debugger
                store.dispatch("app-partner/updateCompanyInfo", this.partnerData.partner[0])
                    .then((res) => {
                        console.log(res)
                        // debugger
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Partner Account updated successfully',
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
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Error fetching Partner Account',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }
        },
        setup() {

            // const PARTNERS = 'app-partners'
            const toast = useToast()

            // // Register module
            // if (!store.hasModule(PARTNERS)) store.registerModule(PARTNERS, PartnerStoreModule)
            //
            // // UnRegister on leave
            // onUnmounted(() => {
            //     if (store.hasModule(PARTNERS)) store.unregisterModule(PARTNERS)
            // })

            const {goBack} = usePartnersList()


            return {
                goBack,
                partnerData,
                toast,

            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
