<template>
    <b-sidebar
        id="add-new-mapping-tier-sidebar"
        :visible="isAddNewMappingTierSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @change="(val) => $emit('update:is-add-new-mapping-tier-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add New User
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>

            <!-- BODY -->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onSubmit)"
                >

                    <!--   Partner ID-->
                    <b-form-group
                        label="Partner ID"
                        label-for="tier_id"
                    >
                        <b-form-select v-model="mappingTierData.partner_id">
                            <option v-for="option in mappingData.mapping.partner_ids" :key="option.vendor_id" :value="option.id">
                                {{ option.vendor_id }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <!--   Lead Type-->
                    <b-form-group
                            label="Lead Type"
                            label-for="lead_type"

                        >
                            <b-form-select v-model="mappingTierData.lead_type">
                                <option v-for="option in leadTypeOptions" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </b-form-select>
                        </b-form-group>

                    <!-- Tier ID -->
                    <b-form-group
                            label="Tier ID"
                            label-for="tier_id"
                        >
                            <b-form-select v-model="mappingTierData.tier_id">
                                <option v-for="option in mappingData.mapping.tier_ids" :key="option.buyername" :value="option.id">
                                    {{ option.buyername }}
                                </option>
                            </b-form-select>
                    </b-form-group>

                    <!-- Status-->
                    <b-form-group
                        label="Status"
                        label-for="status"
                    >
                    <b-form-select v-model="mappingTierData.status">
                        <option v-for="option in statusOptions" :key="option.label" :value="option.value">
                            {{ option.label }}
                        </option>
                    </b-form-select>
                    </b-form-group>



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
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BFormSelect} from 'bootstrap-vue'
    import { ValidationProvider, ValidationObserver } from 'vee-validate'
    import { required, alphaNum, email } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import { ref } from '@vue/composition-api'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'
    import useMappingTiersList from '../mapping-tier-list/useMappingTierList'
    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            vSelect,
            BFormSelect,
            // Form Validation,
            ValidationProvider,
            ValidationObserver,
            ToastificationContent },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddNewMappingTierSidebarActive',
            event: 'update:is-add-new-mapping-tier-sidebar-active',
        },
        props: {
            isAddNewMappingTierSidebarActive: {
                type: Boolean,
                required: true,
            },
            mappingData: {
                type: Object,
                required: true,
            },
        },

        setup(props, { emit }) {
            const filterTierData = ref(null);
            const toast = useToast()
            const blankUserData = {
                tier_id: '',
                lead_type: '',
                status: '',
                partner_id: ''
            }
            const mappingTierData = ref(JSON.parse(JSON.stringify(blankUserData)))
            const resetmappingTierData = () => {
                mappingTierData.value = JSON.parse(JSON.stringify(blankUserData))
            }
            const onSubmit = () => {
                store.dispatch('app-mapping-tier/addTier', mappingTierData.value)
                    .then(() => {
                        toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Notification',
                                text: 'Partner added successfully',
                                variant: 'success',
                                icon: 'CheckIcon'
                            },
                        })
                        emit('refetch-data')
                        emit('update:is-add-new-partner-sidebar-active', false)
                    })
                    .catch((error) => {
                        // loading.value = false;
                        toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Error creating Partner',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }
            const { statusOptions, leadTypeOptions, goBack} = useMappingTiersList()
            const { refFormObserver, getValidationState } = formValidation(resetmappingTierData)

            store.dispatch('app-mapping-tier/fetchFilterDataOptions')
                .then(response => {
                    filterTierData.value = response.data.filterTierData
                })
                .catch(error => {
                    filterTierData.value = undefined
                    // if (error.response.status === 404) {
                    //     filterTierData.value = undefined
                    // }
                })




            return {
                mappingTierData,
                filterTierData,
                onSubmit,
                refFormObserver,
                getValidationState,
                // resetForm,
                goBack,

                statusOptions,
                leadTypeOptions,

                ToastificationContent,
                toast,

            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-mapping-tier-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
