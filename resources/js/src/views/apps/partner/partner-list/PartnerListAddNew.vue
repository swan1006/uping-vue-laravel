<template>
    <b-sidebar
        id="add-new-partner-sidebar"
        :visible="isAddNewPartnerSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-partner-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add New Partner
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
                    @submit.prevent="onSubmit"
                    @reset.prevent="resetForm"
                >

                    <!-- Vendor ID -->
                    <b-form-group
                        label="Vendor ID"
                        label-for="vendor_id"
                    >
                        <b-form-input
                            id="vendor_id"
                            v-model="partnerData.vendor_id"
                        />
                    </b-form-group>

                    <b-form-group
                        label="User ID"
                        label-for="status"
                    >
                        <b-form-select v-model="partnerData.user_id">
                            <option v-for="option in userListData" :key="option.id" :value="option.id">
                                {{ option.username }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group
                        label="Lead Type"
                        label-for="lead_type"
                    >
                        <v-select
                            v-model="partnerData.lead_type"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="leadTypeOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="lead_type"
                        />
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
        </template>
    </b-sidebar>
</template>

<script>
    import { BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BFormSelect } from 'bootstrap-vue'
    import { ValidationProvider, ValidationObserver } from 'vee-validate'
    import { required, alphaNum, email } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import { ref } from '@vue/composition-api'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import countries from '@/@fake-db/data/other/countries'
    import store from '@/store'
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
            BFormSelect,
            vSelect,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
            ToastificationContent,
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddNewPartnerSidebarActive',
            event: 'update:is-add-new-partner-sidebar-active',
        },
        props: {
            isAddNewPartnerSidebarActive: {
                type: Boolean,
                required: true,
            },
            roleOptions: {
                type: Array,
                required: true,
            },

        },
        setup(props, { emit }) {
            const userListData = ref(null)
            const toast = useToast()

            const blankPartnerData = {
                user_id: '',
                vendor_id: '',

            }

            const leadTypeOptions = [
                { label: 'UK', value: 1 },
                { label: 'USA', value: 2 },
            ]


            const partnerData = ref(JSON.parse(JSON.stringify(blankPartnerData)))
            const resetpartnerData = () => {
                partnerData.value = JSON.parse(JSON.stringify(blankPartnerData))
            }

            const onSubmit = () => {
                store.dispatch('app-partners/addPartner', partnerData.value)
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

            store.dispatch('app-partners/fetchUserIds')
                .then(response => {
                    userListData.value = response.data.userListData
                })
                .catch(error => {
                    userListData.value = undefined
                })


            const { refFormObserver, getValidationState, resetForm } = formValidation(resetpartnerData)

            return {
                partnerData,
                onSubmit,
                refFormObserver,
                getValidationState,
                resetForm,
                userListData,
                leadTypeOptions,
                toast,
                ToastificationContent
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-partner-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
