<template>
  <div>

    <!-- Header: Personal Info -->
    <div class="d-flex">
      <feather-icon
        icon="SendIcon"
        size="19"
      />
      <h4 class="mb-0 ml-50">
        Lander Information
      </h4>
    </div>

    <!-- Form: Personal Info Form -->
    <b-form class="mt-1">
      <b-row>

          <!-- Field: Lander Name -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Lander Name"
                  label-for="lander_name"
              >
                  <b-form-input
                      id="lander_name"
                      v-model="offerData.lander_name"
                  />
              </b-form-group>
          </b-col>


          <!-- Field: Lander Tracking URL -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Lander Tracking URL"
                  label-for="lander_tracking_url"
              >
                  <b-form-input
                      id="lander_tracking_url"
                      v-model="offerData.lander_tracking_url"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Lander Para Tracking URL -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Lander Para Tracking URL"
                  label-for="lander_para_tracking_url"
              >
                  <b-form-input
                      id="lander_para_tracking_url"
                      v-model="offerData.lander_para_tracking_url"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Lander Preview URL -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Lander Preview URL"
                  label-for="lander_preview_url"
              >
                  <b-form-input
                      id="lander_preview_url"
                      v-model="offerData.lander_preview_url"
                  />
              </b-form-group>
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
  },
    props: {
      offerData: {
          type: Object,
          required:true,
      }
    },
  setup(props) {
    const buyerDataInfo = ref({
      dob: null,
      mobile: '+6595895857',
      website: 'https://rowboat.com/insititious/Angelo',
      language: 'French',
      gender: 'female',
      contactOptions: ['Email', 'Message'],
      addressLine1: 'A-65, Belvedere Streets',
      addressLine2: '',
      postcode: '',
      city: 'New York',
      state: '',
      country: '',
    })

    const languageOptions = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit']

    const genderOptions = [
      { text: 'Male', value: 'male' },
      { text: 'Female', value: 'female' },
    ]

    const contactOptionsOptions = ['Email', 'Message', 'Phone']

    return {
      buyerDataInfo,
      languageOptions,
      genderOptions,
      contactOptionsOptions,
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
