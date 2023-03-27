<template>
  <div>

    <!-- Media -->
    <b-media class="mb-2">
      <template #aside>
        <b-avatar
          ref="previewEl"
          :src="partnerData.partner[0].avatar"
          :text="avatarText(partnerData.partner[0].name)"
          :variant="`light-${resolvePartnerRoleVariant(partnerData.partner[0].role)}`"
          size="90px"
          rounded
        />
      </template>
      <h4 class="mb-1">
        {{ partnerData.partner[0].company.name }}
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

      </div>
    </b-media>

    <!-- Partner Info: Input Fields -->
    <b-form @submit.prevent="updatePartnerForm">
      <b-row>

        <!-- Field: Partnername -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Vendor ID"
            label-for="vendor_id"
          >
            <b-form-input
              id="vendor_id"
              v-model="partnerData.partner[0].partner.vendor_id"
              disabled

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
            label-for="company_name"
          >
            <b-form-input
              id="company_name"
              v-model="partnerData.partner[0].company.name"
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
              v-model="partnerData.partner[0].company.email"
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
              v-model="partnerData.partner[0].status"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="statusOptions"
              :reduce="val => val.value"
              :clearable="false"
              input-id="buyer-status"
            />
          </b-form-group>
        </b-col>

<!--          icoLicense-->
          <b-col
              cols="12"
              md="4"
          >
              <b-form-group
                  label="ICO License"
                  label-for="icoLicense"
              >
                  <b-form-input
                      id="icoLicense"
                      v-model="partnerData.partner[0].partner.icoLicense"
                      type="text"
                  />
              </b-form-group>
          </b-col>


<!--          fcaLicense-->
          <b-col
              cols="12"
              md="4"
          >
              <b-form-group
                  label="FCA License"
                  label-for="fcaLicense"
              >
                  <b-form-input
                      id="fcaLicense"
                      v-model="partnerData.partner[0].partner.fcaLicense"
                      type="text"
                  />
              </b-form-group>
          </b-col>




      </b-row>

    <!-- PERMISSION TABLE -->
<!--    <b-card-->
<!--      no-body-->
<!--      class="border mt-1"-->
<!--    >-->
<!--      <b-card-header class="p-1">-->
<!--        <b-card-title class="font-medium-2">-->
<!--          <feather-icon-->
<!--            icon="LockIcon"-->
<!--            size="18"-->
<!--          />-->
<!--          <span class="align-middle ml-50">Permission</span>-->
<!--        </b-card-title>-->
<!--      </b-card-header>-->
<!--      <b-table-->
<!--        striped-->
<!--        responsive-->
<!--        class="mb-0"-->
<!--        :items="permissionsData"-->
<!--      >-->
<!--        <template #cell(module)="data">-->
<!--          {{ data.value }}-->
<!--        </template>-->
<!--        <template #cell()="data">-->
<!--          <b-form-checkbox :checked="data.value" />-->
<!--        </template>-->
<!--      </b-table>-->
<!--    </b-card>-->

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
import { ref } from '@vue/composition-api'
import usePartnersList from '../partner-list/usePartnerList'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {useToast} from "vue-toastification/composition";
import store from '@/store'


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
    partnerData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { resolvePartnerRoleVariant, goBack } = usePartnersList()
      const toast = useToast()

    const roleOptions = [
      { label: 'Admin', value: 'admin' },
      { label: 'Author', value: 'author' },
      { label: 'Editor', value: 'editor' },
      { label: 'Maintainer', value: 'maintainer' },
      { label: 'Subscriber', value: 'subscriber' },
    ]

    const statusOptions = [
      { label: 'Pending', value: 2 },
      { label: 'Active', value: 1 },
      { label: 'Inactive', value: 0 },
    ]

    const permissionsData = [
      {
        module: 'AFF_111',
        UK: true,
        USA: false,
        Offer: false,
      },
      {
        module: 'AFF_222',
          UK: true,
          USA: false,
          Offer: false,
      },
    ]

      function updatePartnerForm(ev) {
          ev.preventDefault();
          console.log(ev)
          // debugger

          // loading.value = true;

          // console.log(props.buyerData.user)
          // debugger
          store.dispatch("app-partner/updatePartner",  props.partnerData.partner[0] )
              .then((res) => {
                  console.log(res)
                  // debugger
                  toast({
                      component: ToastificationContent,
                      props: {
                          title: 'Partner Account updated successfully',
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
                          title: 'Error fetching Partner Account',
                          icon: 'AlertTriangleIcon',
                          variant: 'danger',
                      },
                  })

                  if (error.response.status === 404) {
                      errors.value = error.response.data.errors;
                  }
              });
      }




      // ? Demo Purpose => Update image on click of update
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.partnerData.avatar = base64
    })

    return {
      resolvePartnerRoleVariant,
      updatePartnerForm,
      avatarText,
      roleOptions,
      statusOptions,
      permissionsData,

        toast,
        ToastificationContent,

      //  ? Demo - Update Image on click of update button
      refInputEl,
      previewEl,
      inputImageRenderer,
        goBack,
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
