<template>
    <div>

        <!-- Header: Company Info -->
        <div class="d-flex">
            <feather-icon
                icon="UserIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Company Information
            </h4>
        </div>

        <!-- Form: Company Info Form -->
        <b-form class="mt-1"   @submit.prevent="updateCompanyInfo">
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
                            v-model="advertiserData.advertiser.company.created_at"
                            class="form-control"
                            :config="{ dateFormat: 'd-m-Y'}"
                            placeholder="DD-MM-YYYY"
                            disabled
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Mobile -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Phone"
                        label-for="phone"
                    >
                        <b-form-input
                            id="phone"
                            v-model="advertiserData.advertiser.company.phone"
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
                            v-model="advertiserData.advertiser.company.website"
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
                            v-model="advertiserData.advertiser.company.skype"
                        />
                    </b-form-group>
                </b-col>



            </b-row>

            <!-- Header: Company Info -->
            <div class="d-flex mt-2">
                <feather-icon
                    icon="MapPinIcon"
                    size="19"
                />
                <h4 class="mb-0 ml-50">
                    Address
                </h4>
            </div>

            <!-- Form: Company Info Form -->
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
                            v-model="advertiserData.advertiser.company.address1"
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
                            v-model="advertiserData.advertiser.company.address2"
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
                            v-model="advertiserData.advertiser.company.postcode"
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
                            v-model="advertiserData.advertiser.company.city"
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
                            v-model="advertiserData.advertiser.company.state"
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
                            v-model="advertiserData.advertiser.company.country"
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
                </b-col>
            </b-row>
        </b-form>
        <!--        <pre>-->

        <!--        </pre>-->
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
    import {onUnmounted, ref} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import useAdvertiserList from '../advertiser-list/useAdvertiserList'
    import store from '@/store'
    import advertiserStoreModule from '../advertiserStoreModule'

    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

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
            ToastificationContent,

        },
        props: {
            advertiserData: {
                type: Object,
                required: true,
            },
        },

        setup(props) {
            const ADVERTISERS = 'app-advertisers'
            const toast = useToast()

            // Register module
            if (!store.hasModule(ADVERTISERS)) store.registerModule(ADVERTISERS, advertiserStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(ADVERTISERS)) store.unregisterModule(ADVERTISERS)
            })


            const loading = ref(false);
            const errors = ref({});

            const genderOptions = [
                {text: 'Male', value: 1},
                {text: 'Female', value: 2},
            ]

            // const contactOptionsOptions = ['Email', 'Message', 'Phone']
            const contactOptionsOptions = [
                {text: 'Email', value: 1},
                {text: 'Phone', value: 2},
                {text: 'Post', value: 3},
            ]

            function updateCompanyInfo(ev) {
                ev.preventDefault();
                // console.log(ev)
                // debugger

                // loading.value = true;

                // console.log(props.advertiserData.advertiser)
                // debugger
                store.dispatch("app-advertisers/updateCompanyInfo",  props.advertiserData.advertiser )
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
                // advertiserData,
                genderOptions,
                contactOptionsOptions,
                updateCompanyInfo,
                ToastificationContent,
                toast
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
