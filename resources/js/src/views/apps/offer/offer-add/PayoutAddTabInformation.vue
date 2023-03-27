<template>
  <div>

    <!-- Header: Personal Info -->
    <div class="d-flex">
      <feather-icon
        icon="SendIcon"
        size="19"
      />
      <h4 class="mb-0 ml-50">
        Payout Information
      </h4>
    </div>

    <!-- Form: Personal Info Form -->
    <b-form class="mt-1">
      <b-row>

          <!-- Field: Payout Type -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Payout Type"
                  label-for="payout_type"
              >
                  <b-form-input
                      id="payout_type"
                      v-model="offerData.payout_type"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Payout Amount -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Payout Amount"
                  label-for="payout_amount"
              >
                  <b-form-input
                      id="payout_amount"
                      v-model="offerData.payout_amount"
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
          Revenue Information
        </h4>
      </div>

      <!-- Form: Personal Info Form -->
      <b-row class="mt-1">


          <!-- Field: Revenue Type -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Revenue Type"
                  label-for="revenue_type"
              >
                  <b-form-input
                      id="revenue_type"
                      v-model="offerData.revenue_type"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Revenue Amount -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Revenue Amount"
                  label-for="revenue_amount"
              >
                  <b-form-input
                      id="revenue_amount"
                      v-model="offerData.revenue_amount"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Revenue Amount -->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Payment Terms"
                  label-for="payment_terms"
              >
                  <b-form-input
                      id="revenue_amount"
                      v-model="offerData.payment_terms"
                  />
              </b-form-group>
          </b-col>

<!--          Currency-->
          <b-col
              cols="12"
              md="6"
              lg="4"
          >
              <b-form-group
                  label="Currency"
                  label-for="currency"
              >
                  <b-form-input
                      id="currency"
                      v-model="offerData.currency"
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

    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
