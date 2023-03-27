<template>
    <div>

        <!-- Media -->
        <validation-observer ref="simpleRules">

            <b-form @submit.prevent="validationForm(addOfferForm)">


                <b-media class="mb-2">
                    <template #aside>
                        <b-avatar
                            ref="previewEl"
                            :src="offerData.logo"
                            :variant="`light-${resolveOfferAvatarVariant(offerData.status)}`"
                            size="90px"
                            rounded
                        />
                        <!--                    :text="avatarText(offerData.name)"-->
                    </template>
                    <h4 class="mb-1">
                        {{ offerData.name }}
                    </h4>
                    <div class="d-flex flex-wrap">
                        <b-button
                            variant="primary"
                            @click="$refs.refInputEl.click()"
                        >
                            <input
                                ref="refInputEl"
                                type="file"
                                class="d-none"
                                @input="inputImageRenderer"
                                v-on:change="onFileChange"
                            >
                            <span class="d-none d-sm-inline">Update</span>
                            <feather-icon
                                icon="EditIcon"
                                class="d-inline d-sm-none"
                            />
                        </b-button>
                        <b-button
                            variant="outline-primary"
                            class="ml-1"
                            @click="goBack"
                        >
                            <span class="d-none d-sm-inline">Back</span>
                            <feather-icon
                                icon="TrashIcon"
                                class="d-inline d-sm-none"

                            />
                        </b-button>
                    </div>
                </b-media>


                <!-- User Info: Input Fields -->

                <b-row>

                    <!-- Field: Name -->
                    <b-col
                        cols="12"
                        md="3"
                    >
                        <b-form-group
                            label="Offer Name"
                            label-for="offerName"
                        >

                            <validation-provider
                                #default="{ errors }"
                                name="Offer Name"
                                rules="required"
                            >
                                <b-form-input
                                    id="offerName"
                                    v-model="offerData.name"
                                    :state="errors.length > 0 ? false:null"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>




                    <!-- Field: Internal -->
                    <b-col
                        cols="12"
                        md="3"
                    >
                        <b-form-group
                            label="Internal"
                            label-for="internal"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Internal"
                                rules="required"
                            >
                            <v-select
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.internal"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="internalOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="internal"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- Field: Internal -->
                    <b-col
                        cols="12"
                        md="3"
                    >
                        <b-form-group
                            label="Multiple Conversions"
                            label-for="multiple_conversions"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Multiple Conversions"
                                rules="required"
                            >
                            <v-select
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.multiple_conversions"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="['Allowed', 'Not Allowed']"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="multiple_conversions"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- Field: Category -->
                    <b-col
                        cols="12"
                        md="3"
                    >
                        <b-form-group
                            label="Category"
                            label-for="category"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Category"
                                rules="required"
                            >
                            <v-select
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.category"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="categoryOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="category"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>


                    <!-- Field: Conversion Action -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                        <b-form-group
                            label="Conversion Action"
                            label-for="Conversion Action"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Conversion Action"
                                rules="required"
                            >
                            <v-select
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.conversion_action"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="conversionActionOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="conversion_action"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!-- Field: Conversion Type -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                        <b-form-group
                            label="Conversion Type"
                            label-for="Conversion Type"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Conversion Type"
                                rules="required"
                            >
                            <v-select
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.conversion_type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="conversionTypeOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="conversion_type"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- Field: Privacy Level -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                        <b-form-group
                            label="Privacy "
                            label-for="privacy_level"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Privacy"
                                rules="required"
                            >
                            <v-select
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.privacy_level"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="privacyLevelOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="privacy-level"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- Field: Status -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                        <b-form-group
                            label="Status"
                            label-for="buyer-status"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Status"
                                rules="required"
                            >
                            <v-select
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.status"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="statusOptions"
                                :reduce="val => val.value"
                                :clearable="false"
                                input-id="buyer-status"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!-- Field: Expire Date -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                        <b-form-group
                            label="Geos"
                            label-for="category"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Geos"
                                rules="required"
                            >

                            <b-form-tags
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.geos"
                                input-id="geos"
                                class="mb-2"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>

                    </b-col>

                    <b-col
                        cols="6"
                        md="3"
                    >
                        <b-form-group
                            label="Expiry Date"
                            label-for="expire_date"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Expiry Date"
                                rules="required"
                            >
                            <b-form-datepicker
                                id="expire_date"
                                local="en"
                                placeholder="Primary Variant"
                                class="mb-1"
                                selected-variant="primary"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>


                </b-row>

                <b-row>
                    <!-- Field: description -->
                    <b-col
                        cols="6"
                        md="6"
                    >
                        <b-form-group
                            label="Description"
                            label-for="description"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Description"
                                rules="required"
                            >
                            <b-form-textarea
                                rows="3"
                                max-rows="6"
                                id="description"
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.description"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- Field: Restrictions -->
                    <b-col
                        cols="6"
                        md="6"
                    >
                        <b-form-group
                            label="Restrictions"
                            label-for="restrictions"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Restrictions"
                                rules="required"
                            >
                            <b-form-textarea
                                rows="3"
                                max-rows="6"
                                id="restrictions"
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.restrictions"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!-- Field: Terms -->
                    <b-col
                        cols="6"
                        md="6"
                    >
                        <b-form-group
                            label="Terms"
                            label-for="terms"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Terms"
                                rules="required"
                            >
                            <b-form-textarea
                                rows="3"
                                max-rows="6"
                                id="terms"
                                 :state="errors.length > 0 ? false:null"
                                v-model="offerData.terms"
                            />
                       <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- Field: Notes -->
                    <b-col
                        cols="6"
                        md="6"
                    >
                        <b-form-group
                            label="Notes"
                            label-for="notes"
                        >
                            <b-form-textarea
                                rows="3"
                                max-rows="6"
                                id="notes"
                                v-model="offerData.notes"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>


                <!-- Action Buttons -->
                <b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    type="submit"
                >
                    Save Changes
                </b-button>
                <b-button
                    variant="outline-secondary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                    type="reset"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                >
                    Reset
                </b-button>

                <b-button
                    variant="outline-primary"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                >
                    Back
                </b-button>
            </b-form>
        </validation-observer>
    </div>
</template>

<script>
    import {
        BButton,
        BMedia,
        BAvatar,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormTextarea,
        BFormFile,
        BFormTags,
        BFormDatepicker,
    } from 'bootstrap-vue'
    import {avatarText} from '@core/utils/filter'
    import {useInputImageRenderer} from '@core/comp-functions/forms/form-utils'
    import vSelect from 'vue-select'
    import {ref} from '@vue/composition-api'
    import useOffersList from '../offer-list/useOfferList'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {useToast} from "vue-toastification/composition";
    import store from '@/store'

    import {ValidationProvider, ValidationObserver} from 'vee-validate'
    import {required, email} from '@validations'

    export default {
        components: {
            BButton,
            BMedia,
            BAvatar,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            vSelect,
            BFormTextarea,
            BFormFile,
            BFormTags,
            BFormDatepicker,
            ToastificationContent,
            ValidationProvider,
            ValidationObserver,
        },
        props: {
            offerData: {
                type: Object,
                required: true,
            },
            internalOptions: {
                type: Array,
                required: true,
            },
            categoryOptions: {
                type: Array,
                required: true,
            },
            conversionActionOptions: {
                type: Array,
                required: true,
            },
            conversionTypeOptions: {
                type: Array,
                required: true,
            },
            privacyLevelOptions: {
                type: Array,
                required: true,
            },
            geoOptions: {
                type: Array,
                required: true,
            },
            statusOptions: {
                type: Array,
                required: true,
            },

        },
        methods: {
            addOfferForm() {
                store.dispatch("app-offer/addOffer", this.offerData)
                    .then((res) => {
                        console.log(res)
                        // debugger
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Account Info updated successfully',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                        // loading.value = false;
                        // router.push({
                        //     name: "Dashboard",
                        // });
                    })
                    .catch((error) => {
                        // loading.value = false;
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Error fetching Account Info',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            },
            onFileChange(e) {
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;

                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                }

                let formData = new FormData();
                formData.append('file', this.file);

                axios.post('/formSubmit', formData, config)
                    .then(function (response) {
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {
                        currentObj.output = error;
                    });
            },
            goBack() {
                history.back()
            },
            validationForm() {
                this.$refs.simpleRules.validate().then(success => {
                    if (success) {
                        // eslint-disable-next-line
                        alert('form submitted!')
                    }
                })
            },
        },
        data() {
            return {
                emailValue: '',
                name: '',
                required,
                email,
            }
        },
        setup(props) {
            const {
                resolveOfferStatusVariant,
                resolveOfferAvatarVariant,
            } = useOffersList()

            const name = ref(null)
            const file = ref(null)
            const success = ref(null)
            const refInputEl = ref(null)
            const previewEl = ref(null)
            const {inputImageRenderer} = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign
                props.offerData.logo = base64
            })


            return {
                name,
                file,
                success,
                refInputEl,
                previewEl,
                inputImageRenderer,
                avatarText,
                // base64Encode,

                resolveOfferStatusVariant,
                resolveOfferAvatarVariant,

                // privacyLevelOptions,
                // categoryOptions,
                // geoOptions,
                // conversionTypeOptions,
                // conversionActionOptions,
                // internalOptions,
                // statusOptions,

                // offerData,

                ToastificationContent,

                // onSubmit
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
