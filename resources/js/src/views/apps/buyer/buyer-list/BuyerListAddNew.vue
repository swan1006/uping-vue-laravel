<template>
    <b-sidebar
        id="add-new-buyer-sidebar"
        :visible="isAddNewBuyerSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-buyer-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add New Buyer
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
                    @reset.prevent="resetForm"
                >


                    <!-- Name -->
                    <validation-provider
                        #default="validationContext"
                        name="name"
                        rules="required"
                    >
                        <b-form-group
                            label="Name"
                            label-for="name"
                        >
                            <b-form-input
                                id="name"
                                v-model="buyerData.name"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Company -->
                    <validation-provider
                        #default="validationContext"
                        name="company"
                        rules="required"
                    >
                        <b-form-group
                            label="Company"
                            label-for="company"
                        >
                            <b-form-input
                                id="company"
                                v-model="buyerData.company"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Email -->
                    <validation-provider
                        #default="validationContext"
                        name="Email"
                        rules="required|email"
                    >
                        <b-form-group
                            label="Email"
                            label-for="email"
                        >
                            <b-form-input
                                id="email"
                                v-model="buyerData.email"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>


                    <!-- Account Manager Contact -->
                    <validation-provider
                        #default="validationContext"
                        name="account_contact1"
                    >
                        <b-form-group
                            label="Account Manager"
                            label-for="account_contact1"
                        >
                            <b-form-input
                                id="account_contact1"
                                v-model="buyerData.account_contact1"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <!-- Finance Contact -->
                    <validation-provider
                        #default="validationContext"
                        name="account_contact2"
                    >
                        <b-form-group
                            label="Finance Contact"
                            label-for="account_contact2"
                        >
                            <b-form-input
                                id="account_contact2"
                                v-model="buyerData.account_contact2"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Phone Contact -->
                    <validation-provider
                        #default="validationContext"
                        name="phone"
                    >
                        <b-form-group
                            label="Phone"
                            label-for="phone"
                        >
                            <b-form-input
                                id="phone"
                                v-model="buyerData.phone"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Address -->
                    <validation-provider
                        #default="validationContext"
                        name="address"
                    >
                        <b-form-group
                            label="Address"
                            label-for="address"
                        >
                            <b-form-input
                                id="address"
                                v-model="buyerData.address"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <!-- City -->
                    <validation-provider
                        #default="validationContext"
                        name="city"
                    >
                        <b-form-group
                            label="City"
                            label-for="city"
                        >
                            <b-form-input
                                id="city"
                                v-model="buyerData.city"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <!-- State -->
                    <validation-provider
                        #default="validationContext"
                        name="state"
                    >
                        <b-form-group
                            label="State"
                            label-for="state"
                        >
                            <b-form-input
                                id="state"
                                v-model="buyerData.state"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <!-- Country -->
                    <validation-provider
                        #default="validationContext"
                        name="country"
                    >
                        <b-form-group
                            label="Country"
                            label-for="country"
                        >
                            <b-form-input
                                id="country"
                                v-model="buyerData.country"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <!-- Website -->
                    <validation-provider
                        #default="validationContext"
                        name="website"
                    >
                        <b-form-group
                            label="Website"
                            label-for="website"
                        >
                            <b-form-input
                                id="website"
                                v-model="buyerData.website"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <!-- Buyer Role -->
                    <validation-provider
                        #default="validationContext"
                        name="buyer_type"
                        rules="required"
                    >
                        <b-form-group
                            label="Buyer Type"
                            label-for="buyer_type"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="buyerData.buyer_type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="buyerTypeOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyer_type"
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
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton} from 'bootstrap-vue'
    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {required, alphaNum, email} from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {ref} from '@vue/composition-api'
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
            prop: 'isAddNewBuyerSidebarActive',
            event: 'update:is-add-new-buyer-sidebar-active',
        },
        props: {
            isAddNewBuyerSidebarActive: {
                type: Boolean,
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
        setup(props, {emit}) {
            const toast = useToast()
            const blankBuyerData = {
                name: '',
                company: '',
                email: '',
                account_contact1: '',
                account_contact2: '',
                phone: '',
                address: '',
                city: '',
                state: '',
                country: '',
                website: '',
                buyer_type: '',
            }

            const buyerData = ref(JSON.parse(JSON.stringify(blankBuyerData)))
            const resetbuyerData = () => {
                buyerData.value = JSON.parse(JSON.stringify(blankBuyerData))
            }

            const onSubmit = () => {
                store.dispatch('app-buyers/addBuyer', buyerData.value)
                    .then(() => {
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Notification',
                                text: 'Buyer added successfully',
                                variant: 'success',
                                icon: 'CheckIcon'
                            },
                        })
                        emit('refetch-data')
                        emit('update:is-add-new-buyer-sidebar-active', false)
                    })
                    .catch((error) => {
                        // loading.value = false;
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Error saving Buyer',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }

            const {refFormObserver, getValidationState, resetForm} = formValidation(resetbuyerData)

            const buyerTypeOptions = [
                { label: 'Lender', value: 'Lender' },
                { label: 'Broker', value: 'Broker' },
            ]


            return {
                buyerData,
                onSubmit,
                buyerTypeOptions,

                refFormObserver,
                getValidationState,
                resetForm,

                toast,
                ToastificationContent
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-buyer-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
