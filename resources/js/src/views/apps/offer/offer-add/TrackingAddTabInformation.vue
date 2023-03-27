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
                        label-for="mobile"
                    >
                        <b-form-input
                            id="mobile"
                            v-model="offerData.tracking_url"
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
                        label-for="mobile"
                    >
                        <b-form-input
                            id="mobile"
                            v-model="offerData.parralell_tracking_url"
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
                        label-for="mobile"
                    >
                        <b-form-input
                            id="mobile"
                            v-model="offerData.tracking_domain_url"
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
                        label-for="mobile"
                    >
                        <b-form-input
                            id="mobile"
                            v-model="offerData.session_lifespan"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Revenue Amount -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Preview URL"
                        label-for="preview_url"
                    >
                        <b-form-input
                            id="preview_url"
                            v-model="offerData.preview_url"
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
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
