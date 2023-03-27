<template>
    <b-sidebar
        id="add-new-postback-mapping-sidebar"
        :visible="isAddNewPostbackMappingSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-postback-mapping-sidebar-active', val)"
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

            <!-- BODY -->

                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onSubmit)"
                    @reset.prevent="resetForm"
                >



                    <!-- postback_name -->

                        <b-form-group
                            label="Postback Name"
                            label-for="postback_name"
                        >
                            <b-form-input
                                id="postback_name"
                                v-model="postbackData.postback_name"
                                trim
                            />
                        </b-form-group>

                    <!-- Postback URL -->
                        <b-form-group
                            label="Postback URL"
                            label-for="affiliatePostbackUrl"
                        >
                            <b-form-input
                                id="affiliatePostbackUrl"
                                v-model="postbackData.affiliatePostbackUrl"
                                trim
                            />

                        </b-form-group>



                    <!-- Partner Role -->
                        <b-form-group
                            label="Global"
                            label-for="global"
                        >
                            <v-select
                                v-model="postbackData.global"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="roleOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="global"
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
            prop: 'isEditNewPostbackMappingSidebarActive',
            event: 'update:is-edit-new-postback-mapping-sidebar-active',
        },
        props: {
            isEditNewPostbackMappingSidebarActive: {
                type: Boolean,
                required: true,
            },
            roleOptions: {
                type: Array,
                required: true,
            },
            postbackData: {
                type: Object,
                required: true,
            }
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
            // const blankPartnerData = {
            //     name: '',
            //     partnername: '',
            //     email: '',
            //     company_name: '',
            //     role: '',
            // }

            // const postbackData = ref(JSON.parse(JSON.stringify(blankPartnerData)))
            // const resetpostbackData = () => {
            //     postbackData.value = JSON.parse(JSON.stringify(blankPartnerData))
            // }

            const onSubmit = () => {
                store.dispatch('app-postback/addPostback', postbackData.value).then(() => {
                    emit('refetch-data')
                    emit('update:is-edit-new-postback-mapping-sidebar-active', false)
                })
            }

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetpostbackData)

            return {
                postbackData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #edit-new-postback-mapping-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
