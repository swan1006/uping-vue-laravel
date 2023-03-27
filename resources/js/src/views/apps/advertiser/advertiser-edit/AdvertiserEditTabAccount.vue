<template>
  <div>

    <!-- Media -->
      <b-media class="mb-2">
          <template #aside>
              <b-avatar
                  ref="previewEl"
                  :src="advertiserData.advertiser.company.avatar"
                  :text="avatarText(advertiserData.advertiser.company.name)"
                  :variant="`light-${resolveAdvertiserRoleVariant(advertiserData.advertiser.company.role)}`"
                  size="90px"
                  rounded
              />
          </template>
          <h4 class="mb-1">
              {{ advertiserData.advertiser.company.name }}
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
      <b-form
          @submit.prevent="updateAccountForm"
      >
      <b-row>

        <!-- Field: Username -->
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
              v-model="advertiserData.advertiser.company.name"
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
              v-model="advertiserData.advertiser.company.email"
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
            label-for="status"
          >
            <v-select
              v-model="advertiserData.advertiser.status"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="statusOptions"
              :reduce="val => val.value"
              :clearable="false"
              input-id="status"
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
          @click="goBack"
          :block="$store.getters['app/currentBreakPoint'] === 'xs'"

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
import { avatarText } from '@core/utils/filter'
import vSelect from 'vue-select'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import useAdvertisersList from '../advertiser-list/useAdvertiserList'
import store from '@/store'
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
    advertiserData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
      const toast = useToast()


      const { goBack, resolveAdvertiserRoleVariant } = useAdvertisersList()

    const roleOptions = [
      { label: 'Admin', value: 'admin' },
      { label: 'Author', value: 'author' },
      { label: 'Editor', value: 'editor' },
      { label: 'Maintainer', value: 'maintainer' },
      { label: 'Subscriber', value: 'subscriber' },
    ]
    const statusOptions = [
      { label: 'Pending', value: 'pending' },
      { label: 'Active', value: 'active' },
      { label: 'Inactive', value: 'inactive' },
    ]
    const permissionsData = [
      {
        module: 'Admin',
        read: true,
        write: false,
        create: false,
        delete: false,
      },
      {
        module: 'Staff',
        read: false,
        write: true,
        create: false,
        delete: false,
      },
      {
        module: 'Author',
        read: true,
        write: false,
        create: true,
        delete: false,
      },
      {
        module: 'Contributor',
        read: false,
        write: false,
        create: false,
        delete: false,
      },
      {
        module: 'User',
        read: false,
        write: false,
        create: false,
        delete: true,
      },
    ]
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.advertiserData.advertiser.avatar = base64
    })

      function updateAccountForm(ev) {
          ev.preventDefault();
          console.log(ev)
          // debugger

          // loading.value = true;

          // console.log(props.advertiserData.advertiser)
          // debugger
          store.dispatch("app-advertisers/updateAccountForm",  props.advertiserData.advertiser )
              .then((res) => {
                  console.log(res)
                  // debugger
                  toast({
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
                  toast({
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
        avatarText,
        resolveAdvertiserRoleVariant,

        updateAccountForm,

        roleOptions,
        statusOptions,

        refInputEl,
        previewEl,
        inputImageRenderer,

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
