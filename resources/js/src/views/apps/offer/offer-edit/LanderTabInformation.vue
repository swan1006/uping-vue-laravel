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


<!--          // TODO: make repeater-->
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
                      v-model="offerData.offer.landers[0].lander_name"
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
                      v-model="offerData.offer.landers[0].lander_tracking_url"
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
                      v-model="offerData.offer.landers[0].lander_preview_url"
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


    return {
        // offerData,
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
