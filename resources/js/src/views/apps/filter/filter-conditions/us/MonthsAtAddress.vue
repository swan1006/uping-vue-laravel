<template>
  <div>

    <!-- Form: Personal Info Form -->
      <b-col
          cols="12"
          md="12"
          lg="12"
      >
          <b-form-group
              label="Should Be Exactly"
              label-for="contact-options"
              label-class="mb-1"
          >
              <b-form-checkbox-group
                  id="issc_value"
                  name="issc_value"
                  v-model="filterData.conditions"
                  :options="shouldContainOptions"
              />
          </b-form-group>
      </b-col>



      <pre>
          {{ filterData }}
      </pre>
      <b-col
          cols="12"
          md="12"
          lg="12"
      >
          <b-form-group
              label="Should Be Exactly"
              label-for="contact-options"
              label-class="mb-1"
          >
              <b-form-checkbox-group
                  id="issb_value"
                  v-model="filterData.conditions"
                  :options="shouldBeOptions"
              />
          </b-form-group>
      </b-col>
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
        filterData: {
            type: Object,
            required: true,
        },
    },

  setup() {
    const filterData = ref({
        conditions: [],
    })


    const languageOptions = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit']

    const genderOptions = [
      { text: 'Male', value: 'male' },
      { text: 'Female', value: 'female' },
    ]

    const shouldContainOptions = [
        { text: 'EmployedFullTime', value: 'EmployedFullTime' },
        { text: 'EmployedPartTime', value: 'EmployedPartTime' },
        { text: 'EmployedTemporary', value: 'EmployedTemporary' },
        { text: 'SelfEmployed', value: 'SelfEmployed' },
    ]
    const shouldBeOptions =   [
        { text: 'EmployedFullTime', value: 'EmployedFullTime' },
        { text: 'EmployedPartTime', value: 'EmployedPartTime' },
        { text: 'EmployedTemporary', value: 'EmployedTemporary' },
        { text: 'SelfEmployed', value: 'SelfEmployed' },
        ]

    return {
        filterData,
      languageOptions,
      genderOptions,

        shouldContainOptions,
        shouldBeOptions,
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
