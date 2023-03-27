<template>
    <div>

        <!-- Header: Company Info -->
        <div class="d-flex">
            <feather-icon
                icon="BuyerIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Company Information
            </h4>
        </div>

        <!-- Form: Company Info Form -->
        <b-form class="mt-1"   @submit.prevent="updateCompanyInfo">
            <b-row>

                <!-- Field: Join Date -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Join Date"
                        label-for="birth-date"
                    >
                        <flat-pickr
                            v-model="userData.user.company.created_at"
                            class="form-control"
                            :config="{ dateFormat: 'd-m-Y'}"
                            placeholder="DD-MM-YYYY"
                            disabled
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Mobile -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Phone"
                        label-for="phone"
                    >
                        <b-form-input
                            id="phone"
                            v-model="userData.user.company.phone"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Website -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Website"
                        label-for="website"
                    >
                        <b-form-input
                            id="website"
                            v-model="userData.user.company.website"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Language -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="IM/Skype"
                        label-for="skype"
                    >
                        <b-form-input
                            id="skype"
                            v-model="userData.user.company.skype"
                        />
                    </b-form-group>
                </b-col>



            </b-row>

            <!-- Header: Company Info -->
            <div class="d-flex mt-2">
                <feather-icon
                    icon="MapPinIcon"
                    size="19"
                />
                <h4 class="mb-0 ml-50">
                    Address
                </h4>
            </div>

            <!-- Form: Company Info Form -->
            <b-row class="mt-1">

                <!-- Field: Address Line 1 -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Address Line 1"
                        label-for="address1"
                    >
                        <b-form-input
                            id="address1"
                            v-model="userData.user.company.address1"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Address Line 2 -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Address Line 2"
                        label-for="address2"
                    >
                        <b-form-input
                            id="address2"
                            v-model="userData.user.company.address2"
                            placeholder="Los Santos"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Postcode -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Postcode"
                        label-for="postcode"
                    >
                        <b-form-input
                            id="postcode"
                            v-model="userData.user.company.postcode"
                            placeholder="597626"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: City -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="City"
                        label-for="city"
                    >
                        <b-form-input
                            id="city"
                            v-model="userData.user.company.city"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: State -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="State"
                        label-for="state"
                    >
                        <b-form-input
                            id="state"
                            v-model="userData.user.company.state"
                            placeholder="Manhattan"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Country -->
                <b-col
                    cols="12"
                    md="6"
                    lg="4"
                >
                    <b-form-group
                        label="Country"
                        label-for="country"
                    >
                        <b-form-input
                            id="country"
                            v-model="userData.user.company.country"
                            placeholder="United States"
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

            function updateCompanyInfo(ev) {
                ev.preventDefault();
                // console.log(ev)
                // debugger

                // loading.value = true;

                // console.log(props.userData.user)
                // debugger
                store.dispatch("app-users/updateCompanyInfo",  props.userData.user )
                    .then((res) => {
                        // console.log(res)
                        // debugger
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Notification',
                                text: 'User updated successfully',
                                variant: 'success',
                                icon: 'CheckIcon'
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
                                title: 'Notification',
                                text: 'User updated successfully',
                                variant: 'danger',
                                icon: 'CheckIcon'
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }


            return {
                // userData,
                genderOptions,
                contactOptionsOptions,
                updateCompanyInfo,
                ToastificationContent,
                toast
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
