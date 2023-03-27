<template>
  <component :is="partnerData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="partnerData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching partner data
      </h4>
      <div class="alert-body">
        No partner found with this partner id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-partners-list'}"
        >
          Partner List
        </b-link>
        for other partners.
      </div>
    </b-alert>

    <b-tabs
      v-if="partnerData"
      pills
    >

      <!-- Tab: Account -->
      <b-tab active>
        <template #title>
          <feather-icon
            icon="UserIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Account</span>
        </template>
        <partner-edit-tab-account
          :partner-data="partnerData"
          class="mt-2 pt-75"
        />
      </b-tab>


      <!-- Tab: Information -->
      <b-tab>
        <template #title>
          <feather-icon
            icon="InfoIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Information</span>
        </template>
        <partner-edit-tab-information class="mt-2 pt-75"    :partner-data="partnerData" />
      </b-tab>

        <!-- Tab: Information -->
        <b-tab>
            <template #title>
                <feather-icon
                    icon="ActivityIcon"
                    size="16"
                    class="mr-0 mr-sm-50"
                />
                <span class="d-none d-sm-inline">Payment Details</span>
            </template>
            <partner-edit-payment-user-info-card class="mt-2 pt-75"    :partner-data="partnerData" />
        </b-tab>

      <!-- Tab: Social -->
<!--      <b-tab>-->
<!--        <template #title>-->
<!--          <feather-icon-->
<!--            icon="Share2Icon"-->
<!--            size="16"-->
<!--            class="mr-0 mr-sm-50"-->
<!--          />-->
<!--          <span class="d-none d-sm-inline">Social</span>-->
<!--        </template>-->
<!--        <partner-edit-tab-social class="mt-2 pt-75"    :partner-data="partnerData" />-->
<!--      </b-tab>-->

        <!-- Tab: partner Mapping -->
<!--        <b-tab active>-->
<!--            <template #title>-->
<!--                <feather-icon-->
<!--                    icon="InfoIcon"-->
<!--                    size="16"-->
<!--                    class="mr-0 mr-sm-50"-->
<!--                />-->
<!--                <span class="d-none d-sm-inline">Mapping</span>-->
<!--            </template>-->
<!--            <partner-mapping-tab-account-->
<!--                :partner-data="partnerData"-->
<!--                class="mt-2 pt-75"-->
<!--            />-->
<!--        </b-tab>-->
    </b-tabs>
  </component>
</template>

<script>
import {
  BTab, BTabs, BCard, BAlert, BLink,
} from 'bootstrap-vue'
import { ref, onUnmounted } from '@vue/composition-api'
import router from '@/router'
import store from '@/store'
import partnerStoreModule from '../PartnerStoreModule'
import PartnerEditTabAccount from './PartnerEditTabAccount.vue'
import PartnerEditTabInformation from './PartnerEditTabInformation.vue'
import PartnerEditTabSocial from './PartnerEditTabSocial.vue'
import PartnerMappingTabAccount from './PartnerMappingTabAccount.vue'
import PartnerEditPaymentUserInfoCard from './PartnerEditPaymentUserInfoCard.vue'

export default {
  components: {
      PartnerEditPaymentUserInfoCard,
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    PartnerEditTabAccount,
    PartnerEditTabInformation,
    PartnerEditTabSocial,
    PartnerEditPaymentUserInfoCard,
    // PartnerMappingTabAccount,
  },
  setup() {
    const partnerData = ref(null)

    const PARTNER_APP_STORE_MODULE_NAME = 'app-partner'

    // Register module
    if (!store.hasModule(PARTNER_APP_STORE_MODULE_NAME)) store.registerModule(PARTNER_APP_STORE_MODULE_NAME, partnerStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(PARTNER_APP_STORE_MODULE_NAME)) store.unregisterModule(PARTNER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-partner/fetchPartner', { id: router.currentRoute.params.id })
      .then(response => { partnerData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          partnerData.value = undefined
        }
      })

    return {
      partnerData,
    }
  },
}
</script>

<style>

</style>
