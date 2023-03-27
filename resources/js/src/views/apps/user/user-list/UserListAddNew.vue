<template>
    <b-sidebar
        id="add-new-user-sidebar"
        :visible="isAddNewUserSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-user-sidebar-active', val)"
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
                    @reset.prevent="resetForm"
                >

                    <!--  Name -->
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
                                v-model="userData.name"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="John Doe"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  Name -->
                    <validation-provider
                        #default="validationContext"
                        name="username"
                        rules="required"
                    >
                        <b-form-group
                            label="Username"
                            label-for="username"
                        >
                            <b-form-input
                                id="username"
                                v-model="userData.username"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="JohnDoe007"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  Email -->
                    <validation-provider
                        #default="validationContext"
                        name="email"
                        rules="required"
                    >
                        <b-form-group
                            label="Email"
                            label-for="email"
                        >
                            <b-form-input
                                id="email"
                                v-model="userData.email"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="JohnDoe007@gmail.com"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  Company Name -->
                    <validation-provider
                        #default="validationContext"
                        name="company_name"
                        rules="required"
                    >
                        <b-form-group
                            label="Email"
                            label-for="company_name"
                        >
                            <b-form-input
                                id="company_name"
                                v-model="userData.company_name"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="Finance LTD"
                            />

                            <b-form-invalid-feedback>
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
    import { ref } from '@vue/composition-api'
    import { required, alphaNum, email } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import countries from '@/@fake-db/data/other/countries'
    import store from '@/store'

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
            prop: 'isAddNewUserSidebarActive',
            event: 'update:is-add-new-user-sidebar-active',
        },
        props: {
            isAddNewUserSidebarActive: {
                type: Boolean,
                required: true,
            },
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
            const blankUserData = {
                name: '',
                username: '',
                email: '',
                status: '',
                is_admin: '',
                role: '',

            }

            const userData = ref(JSON.parse(JSON.stringify(blankUserData)))
            const resetuserData = () => {
                userData.value = JSON.parse(JSON.stringify(blankUserData))
            }
            const onSubmit = () => {
                store.dispatch('app-users/addUser', userData.value).then(() => {
                    emit('refetch-data')
                    emit('update:is-add-new-user-sidebar-active', false)
                })
            }

            const lead_type_options = [
                { label: 'UK', value: 1 },
                { label: 'US', value: 2 },
            ]
            const mode_options = [
                { label: 'Test', value: 0 },
                { label: 'Live', value: 1 },
            ]
            const model_type_options = [
                { label: 'CPA', value: 1 },
                { label: 'CPL', value: 2 },
                { label: 'CPF', value: 3 },
                { label: 'Pingtree', value: 4 },
                { label: 'Hybrid CPL/CPF', value: 5 },
            ]
            const rotate_options = [
                { label: 'CPA', value: 1 },
                { label: 'CPL', value: 2 },
            ]



            const { refFormObserver, getValidationState, resetForm } = formValidation(resetuserData)

            return {
                userData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,
                mode_options,
                lead_type_options,
                model_type_options,
                rotate_options
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-user-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
