<template>
    <b-sidebar
        id="add-new-advertiser-sidebar"
        :visible="isAddAdvertiserOfferSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @change="(val) => $emit('update:is-add-new-advertiser-sidebar-active', val)"
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

                    <!--                    <b-input hidden v-model="advertiserData.mapping.tier_ids" :value="option.value"></b-input>-->

                    <b-form-group
                        label="Tier ID"
                        label-for="tier_id"
                    >
                        <b-form-select v-model="advertiserData.user_id">
                            <option v-for="option in advertiserData.advertisers.user_ids" :key="option.name" :value="option.id">
                                {{ option.name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group
                        label="Lead Type"
                        label-for="lead_type"

                    >
                        <b-form-select v-model="advertiserData.status">
                            <option v-for="option in statusOptions" :value="option.value">
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
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddAdvertiserOfferSidebarActive',
            event: 'update:is-add-new-advertiser-sidebar-active',
        },
        props: {
            isAddNewAdvertiserSidebarActive: {
                type: Boolean,
                required: true,
            },
            roleOptions: {
                type: Array,
                required: true,
            },
            advertiserData: {
                type: Object,
                required: true,
            },
            statusOptions: {
                type: Array,
                required: true,
            },
        },
        // data() {
        //     return {
        //         required,
        //         alphaNum,
        //         email,
        //         // countries,
        //     }
        // },
        setup(props, { emit }) {
            const blankUserData = ref({
                tier_id: '',
                lead_type: '',
                status: '',
                partner_id: ''
            })

            const advertiserData = JSON.parse(JSON.stringify(blankUserData))
            const resetadvertiserData = () => {
                advertiserData.value = JSON.parse(JSON.stringify(blankUserData))
            }
            const onSubmit = () => {
                // console.log(advertiserData)
                // console.log(blankUserData)
                // console.log(advertiserData)
                // console.log(props.advertiserData)
                // debugger
                store.dispatch('app-advertiser/addTier', props.advertiserData).then(() => {
                    emit('refetch-data')
                    emit('update:is-add-new-advertiser-sidebar-active', false)
                })
            }

            // const { statusOptions, leadTypeOptions} = useMappingTierList()

            const { refFormObserver, getValidationState } = formValidation(resetadvertiserData)



            return {
                advertiserData,
                // advertiserData,
                onSubmit,

                refFormObserver,
                getValidationState,
                // resetForm,

            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-advertiser-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
