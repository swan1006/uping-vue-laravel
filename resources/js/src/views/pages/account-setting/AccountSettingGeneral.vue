<template>
    <b-card>
        <b-form class="mt-2" @submit.prevent="updateAccountSettingsForm">

<!--        media-->
        <b-media no-body>
            <b-media-aside>
                <b-avatar
                    ref="previewEl"
                    :src="userData.user.avatar"
                    size="90px"
                    rounded
                />
                <!--/ avatar -->
            </b-media-aside>

            <b-media-body class="mt-75 ml-75">
                <!-- upload button -->
                <b-button
                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                    variant="primary"
                    size="sm"
                    class="mb-75 mr-75"
                    @click="$refs.refInputEl.click()"
                >
                    Update Avatar
                </b-button>
                <b-form-file
                    ref="refInputEl"
                    type="file"
                    accept=".jpg, .png, .gif"
                    :hidden="true"
                    @input="inputImageRenderer"
                    v-on:change="onFileChange"
                />
            </b-media-body>
        </b-media>


        <!--     form-->
            <b-row>
                <b-col sm="6">
                    <b-form-group
                        label="Username"
                        label-for="account-username"
                    >
                        <b-form-input
                            v-model="userData.user.username"
                            placeholder="Username"
                            name="username"
                        />
                    </b-form-group>
                </b-col>
                <b-col sm="6">
                    <b-form-group
                        label="Name"
                        label-for="account-name"
                    >
                        <b-form-input
                            v-model="userData.user.name"
                            name="name"
                            placeholder="Name"
                        />
                    </b-form-group>
                </b-col>
                <b-col sm="6">
                    <b-form-group
                        label="E-mail"
                        label-for="account-email"
                    >
                        <b-form-input
                            v-model="userData.user.email"
                            name="email"
                            placeholder="Email"
                        />

                    </b-form-group>
                </b-col>
                <b-col sm="6">
                    <b-form-group
                        label="Company"
                        label-for="account-company"
                    >
                        <b-form-input
                            v-model="userData.user.company.name"
                            name="company_name"
                            placeholder="Company name"
                        />
                    </b-form-group>
                </b-col>

                <!-- alert -->
                <b-col
                    cols="12"
                    class="mt-75"
                >
                    <b-alert
                        show
                        variant="warning"
                        class="mb-50"
                        v-if="userData.user.email_verified_at == null"
                    >
                        <h4 class="alert-heading">
                            Your email is not confirmed. Please check your inbox.
                        </h4>
                        <div class="alert-body">
                            <b-link class="alert-link">
                                Resend confirmation
                            </b-link>
                        </div>
                    </b-alert>
                </b-col>
                <!--/ alert -->

                <b-col cols="12">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        class="mt-2 mr-1"
                        type="submit"
                    >
                        Save changes
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                        variant="outline-primary"
                        type="reset"
                        class="mt-2"
                        @click="goBack"
                    >
                        Back
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
    </b-card>
</template>

<script>
    import {
        BFormFile,
        BButton,
        BForm,
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BAlert,
        BCard,
        BCardText,
        BMedia,
        BMediaAside,
        BMediaBody,
        BLink,
        BImg,
        BAvatar,
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import {useInputImageRenderer} from '@core/comp-functions/forms/form-utils'
    import {ref} from '@vue/composition-api'
    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {avatarText} from '@core/utils/filter'

    export default {
        components: {
            BButton,
            BForm,
            BImg,
            BFormFile,
            BFormGroup,
            BFormInput,
            BRow,
            BCol,
            BAlert,
            BCard,
            BCardText,
            BMedia,
            BMediaAside,
            BMediaBody,
            BLink,
            ToastificationContent,
            BAvatar,
        },
        directives: {
            Ripple,
        },
        props: {
            userData: {
                type: Object,
                default: () => {
                },
            },

        },
        data() {
            return {
                name: 'bullshit',
                file: '',
                success: ''
            }
        },
        methods: {
            resetForm() {
                this.optionsLocal = JSON.parse(JSON.stringify(this.userData))
            },
            goBack() {
                history.back();
            },
            updateAccountSettingsForm(ev) {
                    ev.preventDefault();
                    console.log(ev)
                    // debugger

                    // loading.value = true;

                    // console.log(props.userData.user)
                    // debugger
                    this.$http.patch('/partner/updateAccountInfo/1', this.userData)
                        .then((res) => {
                            console.log(res)
                            // debugger
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Notification',
                                    text: 'Account Details updated successfully',
                                    variant: 'success',
                                    icon: 'CheckIcon'
                                },
                            })
                        })
                        .catch((error) => {
                            // loading.value = false;
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Notification',
                                    text: 'Error updating account details',
                                    variant: 'danger',
                                    icon: 'ZapIcon'
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
        },

        setup() {
            const refInputEl = ref(null)
            const previewEl = ref(null)
            const toast = useToast()

            const {inputImageRenderer} = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign
                props.userData.user.avatar = base64
            })


            return {
                updateAccountForm,
                avatarText,
                //  ? Demo - Update Image on click of update button
                refInputEl,
                previewEl,
                inputImageRenderer,

                name,
                file,
                success,

                userData,

                toast,
                ToastificationContent
            }
        },
    }
</script>
