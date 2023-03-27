<template>
  <div>
      <b-form
          @submit.prevent="updateAccountForm"
      >
    <!-- Media -->
    <b-media class="mb-2">
      <template #aside>
        <b-avatar
          ref="previewEl"
          :src="userData.user.avatar"
          :text="avatarText(userData.user.name)"
          :variant="`light-${resolveUserRoleVariant(userData.user.role)}`"
          size="90px"
          rounded
        />
      </template>
      <h4 class="mb-1">
        {{ userData.user.name }}
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

    <!-- User Info: Input Fields -->

      <b-row>

        <!-- Field: Username -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Username"
            label-for="username"
          >
            <b-form-input
              id="username"
              v-model="userData.user.username"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Full Name -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Name"
            label-for="full-name"
          >
            <b-form-input
              id="name"
              v-model="userData.user.name"
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
              v-model="userData.user.email"
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
            label-for="user-status"
          >
            <v-select
              v-model="userData.user.status"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="statusOptions"
              :reduce="val => val.value"
              :clearable="false"
              input-id="user-status"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Role -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="User Role"
            label-for="role"
          >
            <v-select
              v-model="userData.user.role"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="roleOptions"
              :reduce="val => val.value"
              :clearable="false"
              input-id="user-role"
            />
          </b-form-group>
        </b-col>

        <!-- Field: Company -->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Company"-->
<!--            label-for="company"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="company"-->
<!--              v-model="userData.user.company.name"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

      </b-row>


    <!-- Action Buttons -->
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
      type="reset"
      :block="$store.getters['app/currentBreakPoint'] === 'xs'"
    >
      Reset
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
import { avatarText } from '@core/utils/filter'
import vSelect from 'vue-select'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import {onUnmounted, ref} from '@vue/composition-api'
import useUserList from '../user-list/useUserList'
import store from '@/store'
import userStoreModule from '../UserStoreModule'

import { useToast } from 'vue-toastification/composition'
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
    ToastificationContent,
  },
  props: {
    userData: {
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
        onFileChange(e){
            console.log(e.target.files[0]);
            this.file = e.target.files[0];
        },
        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
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
        }
    },
  setup(props) {

      const toast = useToast()
      const USERS = 'app-users'

      // Register module
      if (!store.hasModule(USERS)) store.registerModule(USERS, userStoreModule)

      // UnRegister on leave
      onUnmounted(() => {
          if (store.hasModule(USERS)) store.unregisterModule(USERS)
      })

    const { resolveUserRoleVariant, resolveUserStatusVariant , roleOptions, statusOptions, goBack} = useUserList()
    const loading = ref(false);
    const errors = ref({});
    const refInputEl = ref(null)
    const previewEl = ref(null)
    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.userData.user.avatar = base64
    })


      function updateAccountForm(ev) {
          ev.preventDefault();
          console.log(ev)
          // debugger

          // loading.value = true;

          // console.log(props.userData.user)
          // debugger
          store.dispatch("app-users/updateAccountForm",  props.userData.user )
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
      }


    return {
      resolveUserRoleVariant,
      resolveUserStatusVariant,
      avatarText,
      roleOptions,
      statusOptions,

      refInputEl,
      previewEl,
      inputImageRenderer,
      updateAccountForm,
      toast,
      goBack,
      ToastificationContent
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
