<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="advertiserData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching buyer data
      </h4>
      <div class="alert-body">
        No buyer found with this buyer id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-buyers-list'}"
        >
          Buyer List
        </b-link>
        for other buyers.
      </div>
    </b-alert>

    <template v-if="advertiserData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="12"
          lg="12"
          md="12"
        >
          <advertiser-view-user-info-card :advertiser-data="advertiserData" />
        </b-col>
        <b-col
          cols="12"
          md="5"
          xl="3"
          lg="4"
        >
<!--          <advertiser-view-user-plan-card />-->
        </b-col>
      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
<!--          <advertiser-view-user-timeline-card />-->
        </b-col>
        <b-col
          cols="12"
          lg="6"
        >
<!--          <advertiser-view-user-permissions-card />-->
        </b-col>
      </b-row>

      <advertiser-invoice-list :advertiser-data="advertiserData" />
    </template>

  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { ref, onUnmounted } from '@vue/composition-api'
import {
  BRow, BCol, BAlert, BLink,
} from 'bootstrap-vue'
import AdvertiserInvoiceList from '@/views/apps/invoice/advertiser-invoice-list/AdvertiserInvoiceList.vue'
import advertiserStoreModule from '../AdvertiserStoreModule'
import AdvertiserViewUserInfoCard from './AdvertiserViewUserInfoCard.vue'
import AdvertiserViewUserPlanCard from './AdvertiserViewUserPlanCard.vue'
import AdvertiserViewUserTimelineCard from './AdvertiserViewUserTimelineCard.vue'
import AdvertiserViewUserPermissionsCard from './AdvertiserViewUserPermissionsCard.vue'

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    AdvertiserViewUserInfoCard,
    AdvertiserViewUserPlanCard,
    AdvertiserViewUserTimelineCard,
    AdvertiserViewUserPermissionsCard,

    AdvertiserInvoiceList,
  },
  setup() {
    const advertiserData = ref(null)

    const ADVERTISER_APP_STORE_MODULE_NAME = 'app-advertiser'

    // Register module
    if (!store.hasModule(ADVERTISER_APP_STORE_MODULE_NAME)) store.registerModule(ADVERTISER_APP_STORE_MODULE_NAME, advertiserStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(ADVERTISER_APP_STORE_MODULE_NAME)) store.unregisterModule(ADVERTISER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-advertiser/fetchAdvertiser', { id: router.currentRoute.params.id })
      .then(response => { advertiserData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          advertiserData.value = undefined
        }
      })

    return {
      advertiserData,
    }
  },
}
</script>

<style>

</style>
