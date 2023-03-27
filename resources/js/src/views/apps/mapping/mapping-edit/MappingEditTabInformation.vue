<template>
  <div>

    <!-- Header: Personal Info -->
    <div class="d-flex">
      <feather-icon
        icon="BuyerIcon"
        size="19"
      />
      <h4 class="mb-0 ml-50">
        Current Mappings
      </h4>
    </div>

    <!-- Form: Personal Info Form -->
<!--    <b-form class="mt-1">-->
<!--      <b-row>-->

<!--        &lt;!&ndash; Field: Birth Date &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Birth Date"-->
<!--            label-for="birth-date"-->
<!--          >-->
<!--            <flat-pickr-->
<!--              v-model="buyerDataInfo.dob"-->
<!--              class="form-control"-->
<!--              :config="{ dateFormat: 'Y-m-d'}"-->
<!--              placeholder="YYYY-MM-DD"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Mobile &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Mobile"-->
<!--            label-for="mobile"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="mobile"-->
<!--              v-model="buyerDataInfo.mobile"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Website &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Website"-->
<!--            label-for="website"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="website"-->
<!--              v-model="buyerDataInfo.website"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Language &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Language"-->
<!--            label-for="language"-->
<!--          >-->
<!--            <v-select-->
<!--              v-model="buyerDataInfo.language"-->
<!--              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"-->
<!--              :options="languageOptions"-->
<!--              :clearable="false"-->
<!--              input-id="language"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Gender &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Gender"-->
<!--            label-for="gender"-->
<!--            label-class="mb-1"-->
<!--          >-->
<!--            <b-form-radio-group-->
<!--              id="gender"-->
<!--              v-model="buyerDataInfo.gender"-->
<!--              :options="genderOptions"-->
<!--              value="male"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Contact Options &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Contact Options"-->
<!--            label-for="contact-options"-->
<!--            label-class="mb-1"-->
<!--          >-->
<!--            <b-form-checkbox-group-->
<!--              id="contact-options"-->
<!--              v-model="buyerDataInfo.contactOptions"-->
<!--              :options="contactOptionsOptions"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->
<!--      </b-row>-->

<!--      &lt;!&ndash; Header: Personal Info &ndash;&gt;-->
<!--      <div class="d-flex mt-2">-->
<!--        <feather-icon-->
<!--          icon="MapPinIcon"-->
<!--          size="19"-->
<!--        />-->
<!--        <h4 class="mb-0 ml-50">-->
<!--          Address-->
<!--        </h4>-->
<!--      </div>-->

<!--      &lt;!&ndash; Form: Personal Info Form &ndash;&gt;-->
<!--      <b-row class="mt-1">-->

<!--        &lt;!&ndash; Field: Address Line 1 &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Address Line 1"-->
<!--            label-for="address-line-1"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="address-line-1"-->
<!--              v-model="buyerDataInfo.addressLine1"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Address Line 2 &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Address Line 2"-->
<!--            label-for="address-line-2"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="address-line-2"-->
<!--              v-model="buyerDataInfo.addressLine2"-->
<!--              placeholder="Los Santos"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Postcode &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Postcode"-->
<!--            label-for="postcode"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="postcode"-->
<!--              v-model="buyerDataInfo.postcode"-->
<!--              type="number"-->
<!--              placeholder="597626"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: City &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="City"-->
<!--            label-for="city"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="city"-->
<!--              v-model="buyerDataInfo.city"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: State &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="State"-->
<!--            label-for="state"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="state"-->
<!--              v-model="buyerDataInfo.state"-->
<!--              placeholder="Manhattan"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->

<!--        &lt;!&ndash; Field: Country &ndash;&gt;-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="6"-->
<!--          lg="4"-->
<!--        >-->
<!--          <b-form-group-->
<!--            label="Country"-->
<!--            label-for="country"-->
<!--          >-->
<!--            <b-form-input-->
<!--              id="country"-->
<!--              v-model="buyerDataInfo.country"-->
<!--              placeholder="United States"-->
<!--            />-->
<!--          </b-form-group>-->
<!--        </b-col>-->
<!--      </b-row>-->

<!--      <b-row class="mt-2">-->
<!--        <b-col>-->
<!--          <b-button-->
<!--            variant="primary"-->
<!--            class="mb-1 mb-sm-0 mr-0 mr-sm-1"-->
<!--            :block="$store.getters['app/currentBreakPoint'] === 'xs'"-->
<!--          >-->
<!--            Save Changes-->
<!--          </b-button>-->
<!--          <b-button-->
<!--            variant="outline-secondary"-->
<!--            :block="$store.getters['app/currentBreakPoint'] === 'xs'"-->
<!--          >-->
<!--            Reset-->
<!--          </b-button>-->
<!--        </b-col>-->
<!--      </b-row>-->
<!--    </b-form>-->
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
  setup() {
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
