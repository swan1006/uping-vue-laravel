<<template>
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">

            <!-- Login v1 -->
            <b-card class="mb-0">
                <b-link class="brand-logo">
                    <b-img
                      :src="logoUrl"
                      alt="Login V2"
                      class="z-index-0"
                      width="150"
                      height="45"
                  />

                </b-link>

                <b-card-title class="mb-1">
                </b-card-title>
                <b-card-text class="mb-2">
                    Please sign-in to your account
                </b-card-text>

                <!-- form -->
                <validation-observer
                    ref="loginForm"
                    #default="{invalid}"
                >
                    <b-form
                        class="auth-login-form mt-2"
                        @submit.prevent="login"
                    >

                        <!-- email -->
                        <b-form-group
                            label-for="email"
                            label="Email"
                        >
                            <validation-provider
                                #default="{ errors }"
                                name="Email"
                                rules="required|email"
                            >
                                <b-form-input
                                    id="email"
                                    v-model="email"
                                    name="login-email"
                                    :state="errors.length > 0 ? false:null"
                                    placeholder="john@example.com"
                                    autofocus
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>

                        <!-- password -->
                        <b-form-group>
                            <div class="d-flex justify-content-between">
                                <label for="password">Password</label>
                                <b-link :to="{name:'auth-forgot-password-v1'}">
                                    <small>Forgot Password?</small>
                                </b-link>
                            </div>
                            <validation-provider
                                #default="{ errors }"
                                name="Password"
                                rules="required"
                            >
                                <b-input-group
                                    class="input-group-merge"
                                    :class="errors.length > 0 ? 'is-invalid':null"
                                >
                                    <b-form-input
                                        id="password"
                                        v-model="password"
                                        :type="passwordFieldType"
                                        class="form-control-merge"
                                        :state="errors.length > 0 ? false:null"
                                        name="login-password"
                                        placeholder="Password"
                                    />

                                    <b-input-group-append is-text>
                                        <feather-icon
                                            class="cursor-pointer"
                                            :icon="passwordToggleIcon"
                                            @click="togglePasswordVisibility"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>

                        <!-- checkbox -->
                        <b-form-group>
                            <b-form-checkbox
                                id="remember-me"
                                v-model="status"
                                name="checkbox-1"
                            >
                                Remember Me
                            </b-form-checkbox>
                        </b-form-group>

                        <!-- submit button -->
                        <b-button
                            variant="primary"
                            type="submit"
                            block
                            :disabled="invalid"
                        >
                            Sign in
                        </b-button>
                    </b-form>
                </validation-observer>

                <b-card-text class="text-center mt-2">
                    <span>New on our platform? </span>
                    <b-link :to="{name:'auth-register'}">
                        <span>Create an account</span>
                    </b-link>
                </b-card-text>

                <div class="divider my-2">
                    <div class="divider-text">
                        or
                    </div>
                </div>

                <!-- social button -->
                <div class="auth-footer-btn d-flex justify-content-center">
                    <b-button
                        href="javascript:void(0)"
                        variant="facebook"
                    >
                        <feather-icon icon="FacebookIcon" />
                    </b-button>
                    <b-button
                        href="javascript:void(0)"
                        variant="twitter"
                    >
                        <feather-icon icon="TwitterIcon" />
                    </b-button>
                    <b-button
                        href="javascript:void(0)"
                        variant="google"
                    >
                        <feather-icon icon="MailIcon" />
                    </b-button>
                    <b-button
                        href="javascript:void(0)"
                        variant="github"
                    >
                        <feather-icon icon="GithubIcon" />
                    </b-button>
                </div>
            </b-card>
            <!-- /Login v1 -->
        </div>
    </div>
</template>


<script>
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BRow,
  BCol,
  BLink,
  BFormGroup,
  BFormInput,
  BInputGroupAppend,
  BInputGroup,
  BFormCheckbox,
  BCardText,
  BCardTitle,
  BImg,
  BForm,
  BButton,
  BAlert,
    BCard,
  VBTooltip,
} from 'bootstrap-vue'
import useJwt from '@/auth/jwt/useJwt'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import { getHomeRouteForLoggedInUser } from '@/auth/utils'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  directives: {
    'b-tooltip': VBTooltip,
  },
  components: {
    BRow,
    BCol,
    BLink,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    BFormCheckbox,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    BAlert,
      BCard,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      password: '',
      email: '',
      sideImg: require('@/assets/images/pages/flat-bg2.jpg'),
      logoUrl: require('@/assets/images/logo/logo.png'),

      // validation rules
      required,
      // email,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/flat-bg2.jpg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    login() {
      this.$refs.loginForm.validate().then(success => {
        if (success) {
          useJwt
            .login({
              email: this.email,
              password: this.password,
            })
            .then(response => {
              const userData  = response.data.user
                console.log(response.data)
                useJwt.setToken(response.data.access_token)
                useJwt.setRefreshToken(response.data.refresh_token)
                localStorage.setItem('userData', JSON.stringify(userData))
                console.log(userData)
                debugger

                if (userData.is_admin == 1) {
                    this.$router.go('/dashboard/admin/uk').then(() => {
                        debugger
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Welcome ${userData.name || userData.username}`,
                                icon: 'CoffeeIcon',
                                variant: 'success',
                                text: `You have successfully logged in as ${userData.is_admin}. Now you can start to explore!`,
                            },
                        })
                    })
                        .catch(error => {
                            console.log(error)
                            debugger

                            this.$refs.loginForm.setErrors(error.response.data.error)
                        })
                } else if (userData.is_admin == 0) {
                    console.log(userData.is_admin)
                    debugger
                    this.$router.go('/dashboard/partner/uk').then(() => {
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Welcome ${userData.name || userData.username}`,
                                icon: 'CoffeeIcon',
                                variant: 'success',
                                text: `You have successfully logged in as ${userData.is_admin}. Now you can start to explore!`,
                            },
                        })
                    })
                        .catch(error => {
                            console.log(error)
                            debugger

                            this.$refs.loginForm.setErrors(error.response.data.error)
                        })
                } else if (userData.is_admin == 2) {
                    this.$router.go('/dashboard/offer').then(() => {
                        debugger
                        this.$toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                                title: `Welcome ${userData.name || userData.username}`,
                                icon: 'CoffeeIcon',
                                variant: 'success',
                                text: `You have successfully logged in as ${userData.is_admin}. Now you can start to explore!`,
                            },
                        })
                    })
                        .catch(error => {
                            console.log(error)
                            debugger

                            this.$refs.loginForm.setErrors(error.response.data.error)
                        })
                }

            })

        }
      }).catch(error => {
          console.log(error)
          debugger

          this.$refs.loginForm.setErrors(error.response.data.error)
      })
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/page-auth.scss';
</style>
