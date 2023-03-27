<template>
  <div>



    <!-- PostbackMapping Info: Input Fields -->
    <b-form @submit.prevent="updatePostbackForm">
      <b-row>

        <!-- Field: Name -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Postback Name"
            label-for="postback_name"
          >
            <b-form-input
              id="postback_name"
              v-model="postbackMappingData.postback.postback_name"
            />
          </b-form-group>
        </b-col>

          <!-- Field: Postback URL -->
          <b-col
              cols="12"
              md="4"
          >
              <b-form-group
                  label="Postback URL"
                  label-for="affiliatePostbackUrl"
              >
                  <b-form-input
                      id="affiliatePostbackUrl"
                      v-model="postbackMappingData.postback.affiliatePostbackUrl"
                  />
              </b-form-group>
          </b-col>

        <!-- Field: Global -->
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Global"
            label-for="global"
          >
            <v-select
              v-model="postbackMappingData.postback.global"
              :reduce="val => val.value"
              :clearable="false"
              input-id="global"
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
import usePostbackMappingsList from '../postback-mapping-list/usePostbackMappingList'
import store from '@/store'
import router from '@/router'

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
      ToastificationContent,
  },
    props: {
        postbackMappingData: {
            type: Object,
            required: true,
        },
    },
  setup(props) {

      function goBack() {
          history.back();
      }

      const {resolvePostbackMappingRoleVariant, statusOptions } = usePostbackMappingsList()

      const roleOptions = [
          {label: 'Admin', value: 'admin'},
          {label: 'Author', value: 'author'},
          {label: 'Editor', value: 'editor'},
          {label: 'Maintainer', value: 'maintainer'},
          {label: 'Subscriber', value: 'subscriber'},
      ]






      // ? Demo Purpose => Update image on click of update
      const refInputEl = ref(null)
      const previewEl = ref(null)
      const toast = useToast()

      const {inputImageRenderer} = useInputImageRenderer(refInputEl, base64 => {
          // eslint-disable-next-line no-param-reassign
          props.postbackMappingData.avatar = base64
      })

      function updatePostbackForm(ev) {
          ev.preventDefault();
          console.log(ev)
          debugger

          store.dispatch("app-postback-mapping/updatePostbackMapping", props.postbackMappingData.postback)
              .then((res) => {
                  console.log(res)
                  debugger
                  toast({
                      component: ToastificationContent,
                      props: {
                          title: 'Postback Mapping updated successfully',
                          icon: 'CheckCircleIcon',
                          variant: 'success',
                      },
                  })
              })
              .catch((error) => {
                  toast({
                      component: ToastificationContent,
                      props: {
                          title: 'Error updating Postback Mapping',
                          icon: 'AlertTriangleIcon',
                          variant: 'danger',
                      },
                  })
                  if (error.response.status === 404) {
                      errors.value = error.response.data.errors;
                  }
              });
          loading.value = true;


      }



    return {
      resolvePostbackMappingRoleVariant,
      avatarText,
      roleOptions,
      statusOptions,

      //  ? Demo - Update Image on click of update button
      refInputEl,
      previewEl,
      inputImageRenderer,
      updatePostbackForm,
      goBack,
        toast,
        ToastificationContent,
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
