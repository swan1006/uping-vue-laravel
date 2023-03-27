<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">
            <feather-icon
                icon="SendIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Tracking Information
            </h4>
        </div>

        <!-- Form: Personal Info Form -->
        <b-form class="mt-1">
            <b-row>

                <!-- Field: Tracking URL -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Tracking URL"
                        label-for="tracking_url"
                    >
                        <b-form-input
                            id="tracking_url"
                            v-model="offerData.offer.tracking.tracking_url"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Parrallel Tracking URL  -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Parrallel Tracking URL"
                        label-for="parallel_tracking_url"
                    >
                        <b-form-input
                            id="parallel_tracking_url"
                            v-model="offerData.offer.tracking.parallel_tracking_url"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field:  Tracking Domain URL  -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Tracking Domain URL"
                        label-for="tracking_domain_url"
                    >
                        <b-form-input
                            id="tracking_domain_url"
                            v-model="offerData.offer.tracking.tracking_domain_url"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Session lifespan -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Session lifespan"
                        label-for="session_lifespan"
                    >
                        <b-form-input
                            id="session_lifespan"
                            v-model="offerData.offer.tracking.session_lifespan"
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
            return {
                // offerData,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
