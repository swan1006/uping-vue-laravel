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
              md="4"
          >
              <b-form-group
                  label="Payout Type"
                  label-for="payoutType"
              >
                  <v-select
                      v-model="offerData.offer.payout.payoutType"
                      :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                      :options="['CPA', 'CPL']"
                      :reduce="val => val.value"
                      :clearable="false"
                      input-id="multiple_conversions"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Payout Amount -->
          <b-col
              cols="12"
              md="4"
              lg="4"
          >
              <b-form-group
                  label="Payout Amount"
                  label-for="payout_amount"
              >
                  <b-form-input
                      id="payout_amount"
                      v-model="offerData.offer.payout.payoutAmount"
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
              md="4"
          >
              <b-form-group
                  label="Revenue Type"
                  label-for="revenueType"
              >
                  <v-select
                      v-model="offerData.offer.payout.revenueType"
                      :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                      :options="['CPA', 'CPL']"
                      :reduce="val => val.value"
                      :clearable="false"
                      input-id="revenueType"
                  />
              </b-form-group>
          </b-col>

          <!-- Field: Revenue Amount -->
          <b-col
              cols="12"
              md="4"
              lg="4"
          >
              <b-form-group
                  label="Revenue Amount"
                  label-for="revenue_amount"
              >
                  <b-form-input
                      id="revenue_amount"
                      v-model="offerData.offer.payout.revenueAmount"
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
                Currency & Terms
            </h4>
        </div>

        <b-row class="mt-1">

          <!-- Field: Currency -->
          <b-col
              cols="12"
              md="4"
          >
              <b-form-group
                  label="Currency"
                  label-for="currency"
              >
                  <v-select
                      v-model="offerData.offer.payout.currency"
                      :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                      :options="['CPA', 'CPL']"
                      :reduce="val => val.value"
                      :clearable="false"
                      input-id="multiple_conversions"
                  />
              </b-form-group>
          </b-col>

            <!-- Field: Payment Terms -->
            <b-col
                cols="12"
                md="4"
            >
                <b-form-group
                    label="Payment Terms"
                    label-for="currency"
                >
                    <v-select
                        v-model="offerData.offer.payout.payment_terms"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="['CPA', 'CPL']"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="payment_terms"
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
