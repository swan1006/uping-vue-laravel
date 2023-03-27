<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">
            <feather-icon
                icon="BuyerIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Payment Details
            </h4>
        </div>

        <!-- Form: Personal Info Form -->
        <b-form class="mt-1"  @submit.prevent="updateUserPaymentInfo">
            <b-row>


                <!-- Field: Bank Name -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Bank Name"
                        label-for="bank_name"
                    >
                        <b-form-input
                            id="bank_name"
                            v-model="userData.user.payment.bank_name"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Bank Account Number -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Bank Account Number"
                        label-for="bank_account_number"
                    >
                        <b-form-input
                            id="bank_account_number"
                            v-model="userData.user.payment.bank_account_number"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Bank Account IBAN -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="IBAN"
                        label-for="bank_iban"
                    >
                        <b-form-input
                            id="bank_iban"
                            v-model="userData.user.payment.bank_iban"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Bank Account SWIFT -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="SWIFT"
                        label-for="bank_swift"
                    >
                        <b-form-input
                            id="bank_swift"
                            v-model="userData.user.payment.bank_swift"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Bank Account Sortcode -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Sortcode"
                        label-for="sortcode"
                    >
                        <b-form-input
                            id="bank_sortcode"
                            v-model="userData.user.payment.bank_sortcode"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Bank Account Country -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Country"
                        label-for="bank_country"
                    >
                        <b-form-input
                            id="bank_country"
                            v-model="userData.user.payment.bank_country"
                        />
                    </b-form-group>
                </b-col>
                <!-- Field: Bank Account Phone -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Phone"
                        label-for="bank_phone"
                    >
                        <b-form-input
                            id="bank_phone"
                            v-model="userData.user.payment.bank_phone"
                        />
                    </b-form-group>
                </b-col>



            </b-row>



            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        type="submit"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
<!--        <pre>-->

<!--        </pre>-->
    </div>
</template>

<script>
    import {
        BRow,
        BCol,
        BForm,
        BFormGroup,
        BFormInput,
        BFormRadioGroup,
        BFormCheckboxGroup,
        BButton
    } from 'bootstrap-vue'
    import flatPickr from 'vue-flatpickr-component'
    import {onUnmounted, ref} from '@vue/composition-api'
    import vSelect from 'vue-select'
    import useUserList from '../user-list/useUserList'
    import store from '@/store'
    import userStoreModule from '../UserStoreModule'

    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BRow,
            BCol,
            BForm,
            BFormGroup,
            flatPickr,
            BFormInput,
            vSelect,
            BFormRadioGroup,
            BFormCheckboxGroup,
            BButton,
            ToastificationContent,

        },
        props: {
            userData: {
                type: Object,
                required: true,
            },
        },

        setup(props) {
            const USERS = 'app-users'
            const toast = useToast()

            // Register module
            if (!store.hasModule(USERS)) store.registerModule(USERS, userStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(USERS)) store.unregisterModule(USERS)
            })


            const loading = ref(false);
            const errors = ref({});

            const genderOptions = [
                {text: 'Male', value: 1},
                {text: 'Female', value: 2},
            ]

            // const contactOptionsOptions = ['Email', 'Message', 'Phone']
            const contactOptionsOptions = [
                {text: 'Email', value: 1},
                {text: 'Phone', value: 2},
                {text: 'Post', value: 3},
            ]

            function updateUserPaymentInfo(ev) {
                ev.preventDefault();
                // console.log(ev)
                // debugger

                // loading.value = true;

                // console.log(props.userData.user)
                // debugger
                store.dispatch("app-users/updateUserPaymentInfo",  props.userData.user )
                    .then((res) => {
                        // console.log(res)
                        // debugger
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Payment Information updated successfully',
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
                                title: 'Error updating Payment Information',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }


            return {
                userData,
                genderOptions,
                contactOptionsOptions,
                updateUserPaymentInfo,
                ToastificationContent,
                toast
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
