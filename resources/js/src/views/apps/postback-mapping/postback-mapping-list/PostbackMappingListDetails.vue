<template>
    <b-sidebar
        id="details-new-postback-mapping-sidebar"
        :visible="isDetailsNewPostbackMappingSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-details-new-postback-mapping-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Postback Details
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>


            <b-col
                cols="12"
                xl="12"
                md="12"
            >
                <table class="mt-2 mt-xl-0 w-100 align-content-center">

                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">AFF ID</span>
                        </th>
                        <td class="pb-50 text-capitalize ">
                            <b-badge  variant="light-primary">
                                {{ postbackData.postback.vendor_id }}
                            </b-badge>

                        </td>
                    </tr>

                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Postback URL</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge  variant="light-success">
                                {{ postbackData.postback.postbacks[0].affiliatePostbackUrl }}
                            </b-badge>

                        </td>
                    </tr>

                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Postback URL</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge  variant="light-success">
                                {{ postbackData.postback.postbacks[0].affiliatePostbackUrl }}
                            </b-badge>

                        </td>
                    </tr>

                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Postback Name</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge  variant="light-success">
                                {{ postbackData.postback.postbacks[0].postback_name }}
                            </b-badge>

                        </td>
                    </tr>

                </table>


            </b-col>
        </template>
    </b-sidebar>
</template>

<script>
    import { BCol, BBadge,BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton } from 'bootstrap-vue'
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
            BBadge,
            BCol,
            vSelect,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isDetailsNewPostbackMappingSidebarActive',
            event: 'update:is-details-new-postback-mapping-sidebar-active',
        },
        props: {
            isDetailsNewPostbackMappingSidebarActive: {
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


            const onSubmit = () => {
                store.dispatch('app-postback/addPostback', postbackData.value).then(() => {
                    emit('refetch-data')
                    emit('update:is-details-new-postback-mapping-sidebar-active', false)
                })
            }


            return {
                postbackData,
                onSubmit,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #details-new-postback-mapping-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
