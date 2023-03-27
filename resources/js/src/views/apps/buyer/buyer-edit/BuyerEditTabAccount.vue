<template>
    <div>

        <!-- Media -->
        <b-form @submit.prevent="updateBuyerForm">

            <b-media class="mb-2">
                <template #aside>
                    <b-avatar
                        ref="previewEl"
                        :src="buyerData.buyer.avatar"
                        :text="avatarText(buyerData.buyer.name)"
                        :variant="`light-${resolveBuyerRoleVariant(buyerData.buyer.role)}`"
                        size="90px"
                        rounded
                    />
                </template>
                <h4 class="mb-1">
                    {{ buyerData.buyer.company.name }}
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
                </div>
            </b-media>

            <!-- Buyer Info: Input Fields -->
            <b-row>

                <!-- Field: Buyer name -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Name"
                        label-for="Name"
                    >
                        <b-form-input
                            id="name"
                            v-model="buyerData.buyer.name"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Full Name -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Company"
                        label-for="company"
                    >
                        <b-form-input
                            id="company"
                            v-model="buyerData.buyer.company.name"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Email -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Email"
                        label-for="email"
                    >
                        <b-form-input
                            id="email"
                            v-model="buyerData.buyer.company.email"
                            type="email"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Status -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Status"
                        label-for="buyer-status"
                    >
                        <v-select
                            v-model="buyerData.buyer.status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-status"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Role -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Buyer Type"
                        label-for="buyer_type"
                    >
                        <v-select
                            v-model="buyerData.buyer.buyer_type"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="roleOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-role"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Email -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Account Contact"
                        label-for="account_contact1"
                    >
                        <b-form-input
                            id="account_contact1"
                            v-model="buyerData.buyer.account_contact1"
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
                variant="outline-secondary"
                type="reset"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                @click="goBack"
            >
                Back
            </b-button>
        </b-form>

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
    } from 'bootstrap-vue'
    import {avatarText} from '@core/utils/filter'
    import vSelect from 'vue-select'
    import {useInputImageRenderer} from '@core/comp-functions/forms/form-utils'
    import {ref} from '@vue/composition-api'
    import useBuyersList from '../buyer-list/useBuyerList'
    import store from '@/store'
    import {useToast} from "vue-toastification/composition";
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

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
        },
        props: {
            buyerData: {
                type: Object,
                required: true,
            },
        },
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                name: '',
                file: '',
                success: ''
            };
        },
        methods: {
            onFileChange(e) {
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
            },
        },
        setup(props) {
            const {resolveBuyerRoleVariant, goBack} = useBuyersList()
            const toast = useToast()

            function updateBuyerForm(ev) {
                ev.preventDefault();
                console.log(ev)
                // debugger

                // loading.value = true;

                // console.log(props.buyerData.user)
                // debugger
                store.dispatch("app-buyers/updateBuyerForm", props.buyerData.buyer)
                    .then((res) => {
                        console.log(res)
                        // debugger
                        toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Buyer Account updated successfully',
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
                        toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Error fetching Buyer Account',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }


            const roleOptions = [
                {label: 'Lender', value: 1},
                {label: 'Broker', value: 2},
            ]

            const statusOptions = [
                {label: 'Pending', value: 2},
                {label: 'Active', value: 1},
                {label: 'Inactive', value: 0},
            ]


            // ? Demo Purpose => Update image on click of update
            const refInputEl = ref(null)
            const previewEl = ref(null)

            const {inputImageRenderer} = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign
                props.buyerData.buyer.avatar = base64
            })

            return {
                resolveBuyerRoleVariant,
                updateBuyerForm,
                avatarText,
                roleOptions,
                statusOptions,
                toast,
                ToastificationContent,
                goBack,

                //  ? Demo - Update Image on click of update button
                refInputEl,
                previewEl,
                inputImageRenderer,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
