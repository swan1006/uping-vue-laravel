<template>
  <div>

    <!-- Media -->

    <!-- Postback Info: Input Fields -->
    <b-form>
      <b-row>

        <!-- Field: Postbackname -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Vendor ID"
            label-for="buyername"
          >
            <b-form-input
              id="buyername"
              v-model="vendor_id"
            />
          </b-form-group>
        </b-col>

          <b-form-group
              label="Name"
              label-for="postback_name"
          >
              <b-form-input
                  id="postback_name"
                  v-model="postback_name"
                  trim
              />
          </b-form-group>

          <!-- Posback URL -->
          <b-form-group
              label="Posback URL"
              label-for="affiliatePostbackUrl"
          >
              <b-form-input
                  id="affiliatePostbackUrl"
                  v-model="affiliatePostbackUrl"
                  trim
              />
          </b-form-group>

          <!-- Global -->
          <b-form-group
              label="Global"
              label-for="global"
          >
              <b-form-select v-model="global" class="mb-3">
                  <b-form-select-option :value="null">Please select an option</b-form-select-option>
                  <b-form-select-option value="1">Global</b-form-select-option>
                  <b-form-select-option value="0">Non-Global</b-form-select-option>
              </b-form-select>
          </b-form-group>

          <!-- Postback AFF ID -->
          <b-form-group
              label="AFF ID"
              label-for="aff_id"
          >
              <b-form-select
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  class="w-100"
                  :reduce="val => val.value"
                  v-model="partner_id"
              >
                  <option :value="null" selected>Select AFF ID</option>
                  <option v-for="option in filterData.vendor_ids" :key="option.vid" :value="option.vid">
                      {{ option.vid }}
                  </option>
              </b-form-select>
          </b-form-group>




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
              v-model="postbackData.partner.status"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="statusOptions"
              :reduce="val => val.value"
              :clearable="false"
              input-id="buyer-status"
            />
          </b-form-group>
        </b-col>



      </b-row>
    </b-form>

    <!-- PERMISSION TABLE -->
    <b-card
      no-body
      class="border mt-1"
    >
      <b-card-header class="p-1">
        <b-card-title class="font-medium-2">
          <feather-icon
            icon="LockIcon"
            size="18"
          />
          <span class="align-middle ml-50">Permission</span>
        </b-card-title>
      </b-card-header>
      <b-table
        striped
        responsive
        class="mb-0"
        :items="permissionsData"
      >
        <template #cell(module)="data">
          {{ data.value }}
        </template>
        <template #cell()="data">
          <b-form-checkbox :checked="data.value" />
        </template>
      </b-table>
    </b-card>

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
    BFormSelect,
    BFormSelectOption,
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import vSelect from 'vue-select'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import usePostbacksList from '../postback-list/usePostbackList'

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
      BFormSelect,
      BFormSelectOption,
    vSelect,
  },
  props: {
    postbackData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { resolvePostbackRoleVariant } = usePostbacksList()

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

    // ? Demo Purpose => Update image on click of update
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.postbackData.avatar = base64
    })

    return {
      resolvePostbackRoleVariant,
      avatarText,
      roleOptions,
      statusOptions,
      permissionsData,

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
