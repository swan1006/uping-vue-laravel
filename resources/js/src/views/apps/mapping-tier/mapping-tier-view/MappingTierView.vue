<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="mappingTierData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching buyerTier data
      </h4>
      <div class="alert-body">
        No buyerTier found with this buyerTier id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-mapping-tier-list'}"
        >
          BuyerTier List
        </b-link>
        for other buyerTiers.
      </div>
    </b-alert>

      <template v-if="mappingTierData">
          <!-- First Row -->
          <b-row>
              <b-col
                  cols="12"
                  xl="12"
                  lg="12"
                  md="12"
              >
                  <mapping-tier-view-user-info-card
                      :mapping-tier-data="mappingTierData"
                  />
              </b-col>
              <b-col
                  cols="12"
                  md="5"
                  xl="3"
                  lg="4"
              >
<!--                  <buyer-tier-view-user-plan-card :buyer-tier-data="mappingTierData"/>-->
              </b-col>
          </b-row>

          <b-row>
              <b-col
                  cols="12"
                  lg="6"
              >
                  <!--          <buyer-tier-view-mapping-timeline-card />-->
              </b-col>
              <b-col
                  cols="12"
                  lg="6"
              >
                  <!--          <buyer-tier-view-mapping-permissions-card />-->
              </b-col>
          </b-row>


          <!-- Tier invoice List -->
<!--          <invoice-list />-->


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
import mappingTierStoreModule from '../mappingTierStoreModule'
import MappingTierViewUserInfoCard from './MappingTierViewUserInfoCard.vue'
import MappingTierViewUserPlanCard from './MappingTierViewUserPlanCard.vue'
import MappingTierViewUserTimelineCard from './MappingTierViewUserTimelineCard.vue'
import MappingTierViewUserPermissionsCard from './MappingTierViewUserPermissionsCard.vue'
// import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    MappingTierViewUserInfoCard,
    MappingTierViewUserPlanCard,
    MappingTierViewUserTimelineCard,
    MappingTierViewUserPermissionsCard,

    // InvoiceList,

  },
    props: {
        mappingData: {
            type: Object,
            default: null
        }
    },
  setup() {
    const mappingTierData = ref(null)

    const MAPPING = 'app-mapping-tier'

    // Register module
    if (!store.hasModule(MAPPING)) store.registerModule(MAPPING, mappingTierStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(MAPPING)) store.unregisterModule(MAPPING)
    })

    store.dispatch('app-mapping-tier/fetchMappingTier', { id: router.currentRoute.params.id })
      .then(response => {
          mappingTierData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          mappingTierData.value = undefined
        }
      })

    return {
      mappingTierData,
    }
  },
}
</script>

<style>

</style>
