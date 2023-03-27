<template>
  <div>


    <!-- Mapping Info: Input Fields -->
    <b-form>
      <b-row>



        <!-- Field: Status -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Affiliate"
            label-for="buyer-status"
          >
            <v-select
              v-model="mappingData.mapping.status"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="statusOptions"
              :reduce="val => val.value"
              :clearable="false"
              input-id="buyer-status"
            />
          </b-form-group>
        </b-col>
          <b-col
              cols="12"
              md="4"
          >
              <b-form-group
                  label="Buyer Tier"
                  label-for="buyer-status"
              >
                  <v-select
                      v-model="mappingData.mapping.status"
                      :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                      :options="statusOptions"
                      :reduce="val => val.value"
                      :clearable="false"
                      input-id="buyer-status"
                  />
              </b-form-group>
          </b-col>
          <b-col
              cols="12"
              md="4"
          >
              <b-form-group
                  label="Status"
                  label-for="buyer-status"
              >
                  <v-select
                      v-model="mappingData.mapping.status"
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
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import vSelect from 'vue-select'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import useMappingsList from '../mapping-list/useMappingList'

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
    mappingData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { resolveMappingRoleVariant } = useMappingsList()

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
      },
      {
        module: 'AFF_222',
          UK: true,
          USA: false,
      },
    ]

    // ? Demo Purpose => Update image on click of update
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.mappingData.avatar = base64
    })

    return {
      resolveMappingRoleVariant,
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
