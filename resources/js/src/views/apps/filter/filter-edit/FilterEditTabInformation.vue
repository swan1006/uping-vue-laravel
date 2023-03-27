<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">
            <feather-icon
                icon="BuyerIcon"
                size="19"
            />
            <h4 class="mb-0 ml-50">
                Employment Status Conditions
            </h4>
        </div>

        <!-- Form: FILTER FORMS -->
        <b-form class="mt-1" v-if="filterData.filter_type === 'EmploymentStatus'">

            <employment-status :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'Email'">

            <email-filter :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'IncomeCycle'">

            <income-cycle :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'LoanAmount'">

            <loan-amount :filter-data="filterData"/>

            <pre>
    {{ filterData }}
    </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'LoanTerms'">

            <loan-terms :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'MaritalStatus'">

            <marital-status :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'MonthlyCredit'">

            <monthly-credit :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'MonthlyIncome'">

            <monthly-income :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'MonthlyRent'">

            <monthly-income :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'MonthsAtAddress'">

            <months-at-address :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
        <b-form class="mt-1" v-else-if="filterData.filter_type === 'ResidentialStatus'">

            <residential-status :filter-data="filterData"/>

            <pre>
        {{ filterData }}
        </pre>


            <b-row class="mt-2">
                <b-col>
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Save Changes
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                    >
                        Reset
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
import EmploymentStatus from "../filter-conditions/uk/EmploymentStatus";
import EmailFilter from "../filter-conditions/uk/EmailFilter";
import IncomeCycle from "../filter-conditions/uk/IncomeCycle";
import LoanAmount from "../filter-conditions/uk/LoanAmount";
import LoanTerms from "../filter-conditions/uk/LoanTerms";
import MaritalStatus from "../filter-conditions/uk/MaritalStatus";
import MonthlyCredit from "../filter-conditions/uk/MonthlyCredit";
import MonthlyIncome from "../filter-conditions/uk/MonthlyIncome";
import MonthlyRent from "../filter-conditions/uk/MonthlyRent";
import MonthsAtAddress from "../filter-conditions/uk/MonthsAtAddress";
import ResidentialStatus from "../filter-conditions/uk/ResidentialStatus";

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
      EmploymentStatus,
      EmailFilter,
      IncomeCycle,
      LoanAmount,
      LoanTerms,
      MaritalStatus,
      MonthlyCredit,
      MonthlyIncome,
      MonthlyRent,
      MonthsAtAddress,
      ResidentialStatus,

  },
  setup() {

    const languageOptions = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit']

    const genderOptions = [
      { text: 'Male', value: 'male' },
      { text: 'Female', value: 'female' },
    ]

    const contactOptionsOptions = ['Email', 'Message', 'Phone']

    return {
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
