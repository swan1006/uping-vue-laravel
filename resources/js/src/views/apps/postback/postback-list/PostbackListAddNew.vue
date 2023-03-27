<template>
    <b-sidebar
        id="add-new-user-sidebar"
        :visible="isAddNewPostbackSidebarActive"
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
                    Add New Postback123454321
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

                    <!--  Name -->
                        <b-form-group
                            label="Name"
                            label-for="name"
                        >
                            <b-form-input
                                id="name"
                                v-model="postbackData.postback_name"
                                autofocus
                                trim
                                placeholder="John Doe"
                            />

                        </b-form-group>

                    <h1>here</h1>
<!--                    &lt;!&ndash;  Name &ndash;&gt;-->
<!--                    <b-form-group-->
<!--                        label="Tier ID"-->
<!--                        label-for="tier_id"-->
<!--                    >-->
<!--                        <b-form-select v-model="postbackData.tier_id">-->
<!--                            <option v-for="option in filterData.tier_ids" :key="option.tier" :value="option.id">-->
<!--                                {{ option.tier }}-->
<!--                            </option>-->
<!--                        </b-form-select>-->
<!--                    </b-form-group>-->

<!--                    &lt;!&ndash; Status&ndash;&gt;-->
<!--                    <b-form-group-->
<!--                        label="Status"-->
<!--                        label-for="status"-->
<!--                    >-->
<!--                        <b-form-select v-model="postbackData.status">-->
<!--                            <option v-for="option in statusOptions" :key="option.label" :value="option.value">-->
<!--                                {{ option.label }}-->
<!--                            </option>-->
<!--                        </b-form-select>-->
<!--                    </b-form-group>-->








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
            BFormSelect,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddNewPostbackSidebarActive',
            event: 'update:is-add-new-user-sidebar-active',
        },
        props: {
            isAddNewPostbackSidebarActive: {
                type: Boolean,
                required: true,
            },
            filterData: {
                type: Array,
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
            const blankPostbackData = {
                name: '',
                username: '',
                email: '',
                status: '',
                is_admin: '',
                role: '',

            }

            const postbackData = ref(JSON.parse(JSON.stringify(blankPostbackData)))
            const resetpostbackData = () => {
                postbackData.value = JSON.parse(JSON.stringify(blankPostbackData))
            }
            const onSubmit = () => {
                store.dispatch('app-users/addPostback', postbackData.value).then(() => {
                    emit('refetch-data')
                    emit('update:is-add-new-user-sidebar-active', false)
                })
            }

            const lead_type_options = [
                { label: 'UK', value: 1 },
                { label: 'US', value: 2 },
            ]

            const statusOptions = [
                { label: 'Active', value: 1 },
                { label: 'Inactive', value: 0 },
            ]



            const { refFormObserver, getValidationState, resetForm } = formValidation(resetpostbackData)

            return {
                // postbackData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,

                lead_type_options,
                statusOptions,
                filterData,
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
