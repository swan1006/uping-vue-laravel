<template>
  <b-card no-body>
    <b-card-header class="pb-50">
      <h5>
        Filters
      </h5>
    </b-card-header>
    <b-card-body>
      <b-row>
        <b-col
          cols="12"
          md="2"
          class="mb-md-0 mb-2"
        >
          <label>AFF ID</label>
          <v-select
            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
            :value="affiliateFilter"
            :options="roleOptions"
            class="w-100"
            :reduce="val => val.value"
            @input="(val) => $emit('update:affiliateFilter', val)"
          />
        </b-col>
          <b-col
              cols="12"
              md="2"
              class="mb-md-0 mb-2"
          >
              <label>SUB ID</label>
              <v-select
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :value="subIdFilter"
                  :options="roleOptions"
                  class="w-100"
                  :reduce="val => val.value"
                  @input="(val) => $emit('update:subIdFilter', val)"
              />
          </b-col>
        <b-col
          cols="12"
          md="2"
          class="mb-md-0 mb-2"
        >
          <label>TIER ID</label>
          <v-select
            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
            :value="tierFilter"
            :options="planOptions"
            class="w-100"
            :reduce="val => val.value"
            @input="(val) => $emit('update:tierFilter', val)"
          />
        </b-col>
          <b-col
              cols="12"
              md="2"
              class="mb-md-0 mb-2"
          >
              <label>Vendor Price</label>
              <v-select
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :value="vidLeadPriceFilter"
                  :options="planOptions"
                  class="w-100"
                  :reduce="val => val.value"
                  @input="(val) => $emit('update:vidLeadPriceFilter', val)"
              />
          </b-col>
          <b-col
              cols="12"
              md="2"
              class="mb-md-0 mb-2"
          >
              <label>Buyer Price</label>
              <v-select
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :value="buyerLeadPriceFilter"
                  :options="planOptions"
                  class="w-100"
                  :reduce="val => val.value"
                  @input="(val) => $emit('update:buyerLeadPriceFilter', val)"
              />
          </b-col>
          <b-col
              cols="12"
              md="2"
              class="mb-md-0 mb-2"
          >
              <label>Lead Quality</label>
              <v-select
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :value="leadQualityFilter"
                  :options="planOptions"
                  class="w-100"
                  :reduce="val => val.value"
                  @input="(val) => $emit('update:leadQualityFilter', val)"
              />
          </b-col>
          <b-col
              cols="12"
              md="2"
              class="mb-md-0 mb-2"
          >
              <label>Redirection</label>
              <v-select
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :value="redirectionFilter"
                  :options="planOptions"
                  class="w-100"
                  :reduce="val => val.value"
                  @input="(val) => $emit('update:redirectionFilter', val)"
              />
          </b-col>
        <b-col
          cols="12"
          md="2"
          class="mb-md-0 mb-2"
        >
          <label>Status</label>
          <v-select
            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
            :value="statusFilter"
            :options="statusOptions"
            class="w-100"
            :reduce="val => val.value"
            @input="(val) => $emit('update:statusFilter', val)"
          />
        </b-col>
      </b-row>
    </b-card-body>
  </b-card>
</template>

<script>
import { BCard, BCardHeader, BCardBody, BRow, BCol } from 'bootstrap-vue'
import vSelect from 'vue-select'

export default {
  components: {
    BRow,
    BCol,
    BCard,
    BCardHeader,
    BCardBody,
    vSelect,
  },
  props: {
      affiliateFilter: {
      type: [String, null],
      default: null,
    },
      subIdFilter: {
      type: [String, null],
      default: null,
    },
      tierFilter: {
          type: [String, null],
          default: null,
      },
      vendorPriceFilter: {
          type: [String, null],
          default: null,
      },
      buyerPriceFilter: {
          type: [String, null],
          default: null,
      },
      leadQualityFilter: {
          type: [String, null],
          default: null,
      },
      redirectionFilter: {
          type: [String, null],
          default: null,
      },
      statusFilter: {
          type: [String, null],
          default: null,
      },

    statusFilter: {
      type: [String, null],
      default: null,
    },

    statusOptions: {
      type: Array,
      required: true,
    },
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
