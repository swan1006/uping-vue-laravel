<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">
            <feather-icon
                icon="SendIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Day Limits
            </h4>
        </div>

        <!-- Form: Personal Info Form -->
        <b-form class="mt-1">
            <b-row>

                <!-- Field: Day Limit -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Day Click Month Limit"
                        label-for="daylimit"
                    >
                        <b-form-input
                            id="daylimit"
                            v-model="offerData.offer.offer_cap.daylimit"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Week Limit -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Week Click Month Limit"
                        label-for="weeklimit"
                    >
                        <b-form-input
                            id="weeklimit"
                            v-model="offerData.offer.offer_cap.weeklimit"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Month Click Month Limit -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Month Click Month Limit"
                        label-for="monthlimit"
                    >
                        <b-form-input
                            id="monthlimit"
                            v-model="offerData.offer.offer_cap.monthlimit"
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
                    Credit Limits
                </h4>
            </div>

            <!-- Form: Personal Info Form -->
            <b-row class="mt-1">


                <!-- Field: Day Credit Limit -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Day Credit Limit "
                        label-for="daycredit"
                    >
                        <b-form-input
                            id="daycredit"
                            v-model="offerData.offer.offer_cap.daycredit"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Week Credit Limit -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Week Credit Limit "
                        label-for="weekcredit"
                    >
                        <b-form-input
                            id="weekcredit"
                            v-model="offerData.offer.offer_cap.weekcredit"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Month Credit Limit -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Month Credit Limit "
                        label-for="monthcredit"
                    >
                        <b-form-input
                            id="monthcredit"
                            v-model="offerData.offer.offer_cap.monthcredit"
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
            }
        },
        setup(props) {
            const buyerDataInfo = ref({
                dob: null,
                mobile: '+6595895857',
                website: 'https://rowboat.com/insititious/Angelo',
                language: 'French',
                gender: 'female',
                contactOptions: ['Email', 'Message'],
                addressLine1: 'A-65, Belvedere Streets',
                addressLine2: '',
                postcode: '',
                city: 'New York',
                state: '',
                country: '',
            })

            const languageOptions = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit']

            const genderOptions = [
                { text: 'Male', value: 'male' },
                { text: 'Female', value: 'female' },
            ]

            const contactOptionsOptions = ['Email', 'Message', 'Phone']

            return {
                buyerDataInfo,
                languageOptions,
                genderOptions,
                contactOptionsOptions,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
