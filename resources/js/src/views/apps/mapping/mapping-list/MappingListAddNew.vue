<template>
    <b-sidebar
        id="add-new-mapping-sidebar"
        :visible="isAddNewMappingSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-mapping-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add New Mapping
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>


                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onSubmit)"
                    @reset.prevent="resetForm"
                >


                    <!-- Lead Type -->
                    <div>
                        <b-form-select
                            v-model="selected"
                            :options="options"
                        />
                        <b-form-select
                            v-model="selected"
                            :options="options"
                            size="sm"
                            class="mt-1"
                        />
                        <div class="mt-1">
                            Selected: <strong>{{ selected }}</strong>
                        </div>
                    </div>

                    <!-- Vendor ID -->
                    <validation-provider
                        #default="validationContext"
                        name="vendor_id"
                        rules="required"
                    >
                        <b-form-group
                            label="Vendor ID"
                            label-for="vendor_id"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="mappingData.role"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="roleOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="vendor_id"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>


                    <!-- Status -->
                    <validation-provider
                        #default="validationContext"
                        name="status"
                        rules="required"
                    >
                        <b-form-group
                            label="Status"
                            label-for="status"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="mappingData.role"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="statusOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="status"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>



                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            Add
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hide"
                        >
                            Cancel
                        </b-button>
                    </div>

                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>

<script>
    import { BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton } from 'bootstrap-vue'
    import { ValidationProvider, ValidationObserver } from 'vee-validate'
    import { required, alphaNum, email } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import { ref } from '@vue/composition-api'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import countries from '@/@fake-db/data/other/countries'
    import store from '@/store'
    import useMappingsList from './useMappingList'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            vSelect,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddNewMappingSidebarActive',
            event: 'update:is-add-new-mapping-sidebar-active',
        },
        props: {
            isAddNewMappingSidebarActive: {
                type: Boolean,
                required: true,
            },
            roleOptions: {
                type: Array,
                required: true,
            },
            // leadTypeOptions: {
            //     type: Array,
            //     required: true,
            // },
        },
        data() {
            return {
                required,
                alphaNum,
                email,
                countries,
            }
        },
        setup(props, { emit }) {
            const blankMappingData = {
                leadtype: '',
                vendor_id: '',
                buyersetup_id: '',
                status: '',
            }

            const mappingData = ref(JSON.parse(JSON.stringify(blankMappingData)))
            const resetmappingData = () => {
                mappingData.value = JSON.parse(JSON.stringify(blankMappingData))
            }

            const onSubmit = () => {
                store.dispatch('app-mappings/addMapping', mappingData.value).then(() => {
                    emit('refetch-data')
                    emit('update:is-add-new-mapping-sidebar-active', false)
                })
            }

            const { leadTypeOptions, statusOptions } = useMappingsList()

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetmappingData)

            return {
                mappingData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,
                leadTypeOptions,
                statusOptions
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-mapping-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
