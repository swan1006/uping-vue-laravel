<template>
  <div>

    <!-- Header: Personal Info -->
    <div class="d-flex">
      <feather-icon
        icon="UserIcon"
        size="19"
      />
      <h4 class="mb-0 ml-50">
        Posting Settings
      </h4>
    </div>

    <!-- Form: Personal Info Form -->
      <b-form class="mt-1" @submit.prevent="updateBuyerTierForm">

      <b-row>

        <!-- Field: Ping Url Test -->
        <b-col
          cols="12"
          md="6"
          lg="6"
        >
          <b-form-group
            label="Ping URL Test"
            label-for="ping_url_test"
          >
            <b-form-input
              id="ping_url_test"
              v-model="buyerTierData.buyertier.ping_url_test"
            />
          </b-form-group>
        </b-col>

          <!-- Field: Post Url Test -->
          <b-col
              cols="12"
              md="6"
              lg="6"
          >
              <b-form-group
                  label="Post URL Test"
                  label-for="post_url_test"
              >
                  <b-form-input
                      id="post_url_test"
                      v-model="buyerTierData.buyertier.post_url_test"
                  />
              </b-form-group>
          </b-col>

      </b-row>
        <b-row>

          <!-- Field: Ping Url Live -->
          <b-col
              cols="12"
              md="6"
              lg="6"
          >
              <b-form-group
                  label="Ping URL Live"
                  label-for="post_url_live"
              >
                  <b-form-input
                      id="ping_url_live"
                      v-model="buyerTierData.buyertier.ping_url_live"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Post Url Test -->
          <b-col
              cols="12"
              md="6"
              lg="6"
          >
              <b-form-group
                  label="Post URL Live"
                  label-for="post_url_live"
              >
                  <b-form-input
                      id="post_url_live"
                      v-model="buyerTierData.buyertier.post_url_live"
                  />
              </b-form-group>
          </b-col>






      </b-row>

      <!-- Header: Personal Info -->
      <div class="d-flex mt-2">
        <feather-icon
          icon="MapPinIcon"
          size="19"
        />
        <h4 class="mb-0 ml-50">
          Parameters
        </h4>
      </div>

      <!-- Form: Personal Info Form -->
      <b-row class="mt-1">

        <!-- Field: Parameter 1 -->
        <b-col
          cols="12"
          md="6"
          lg="4"
        >
          <b-form-group
            label="Parameter 1"
            label-for="parameter1"
          >
            <b-form-input
              id="parameter1"
              v-model="buyerTierData.buyertier.parameter1"
            />
          </b-form-group>
        </b-col>

          <!-- Field: Parameter 2 -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Parameter 2"
                  label-for="parameter2"
              >
                  <b-form-input
                      id="parameter2"
                      v-model="buyerTierData.buyertier.parameter2"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Parameter 3 -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Parameter 3"
                  label-for="parameter3"
              >
                  <b-form-input
                      id="parameter3"
                      v-model="buyerTierData.buyertier.parameter3"
                  />
              </b-form-group>
          </b-col>

      </b-row>

      <b-row class="mt-2">
        <b-col>
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
            :block="$store.getters['app/currentBreakPoint'] === 'xs'"
          >
            Reset
          </b-button>
            <b-button
                variant="outline-primary"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                @click="goBack"
            >
                Back
            </b-button>

        </b-col>
      </b-row>
    </b-form>
  </div>
</template>

<script>
import { BRow, BCol, BForm, BFormGroup, BFormInput, BFormRadioGroup, BFormCheckboxGroup, BButton } from 'bootstrap-vue'
import flatPickr from 'vue-flatpickr-component'
import { ref } from '@vue/composition-api'
import vSelect from 'vue-select'
import {useToast} from "vue-toastification/composition";
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import store from '@/store'

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
    ToastificationContent
  },
    props: {
        buyerTierData: {
            type: Object,
            required: true,
        },
    },
  setup(props) {
      const toast = useToast()
      function updateBuyerTierForm(ev) {
          ev.preventDefault();
          // console.log(props.userData.user)
          // debugger
          store.dispatch("app-buyer-tier/updateBuyerTierForm", props.buyerTierData.buyertier)
              .then((res) => {
                  // console.log(res)
                  // debugger
                  toast({
                      component: ToastificationContent,
                      props: {
                          title:  'Information updated successfully',
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
                          title: 'Error updating Information',
                          icon: 'AlertTriangleIcon',
                          variant: 'danger',
                      },
                  })

                  if (error.response.status === 404) {
                      errors.value = error.response.data.errors;
                  }
              });
      }


      const languageOptions = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit']

    const genderOptions = [
      { text: 'Male', value: 'male' },
      { text: 'Female', value: 'female' },
    ]

      function goBack(){history.back()}

    const contactOptionsOptions = ['Email', 'Message', 'Phone']

    return {
      // buyerTierData,
      languageOptions,
      genderOptions,
      contactOptionsOptions,
      updateBuyerTierForm,
        toast,
        ToastificationContent,
        goBack

    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
