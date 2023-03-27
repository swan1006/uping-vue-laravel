<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="leadData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching lead data
      </h4>
      <div class="alert-body">
        No lead found with this lead id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-uk-lead-list'}"
        >
          Buyer List
        </b-link>
        for other leads.
      </div>
    </b-alert>

    <template v-if="leadData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="12"
          lg="12"
          md="12"
        >
          <lead-view-user-info-card :lead-data="leadData" />
        </b-col>
      </b-row>
        <LeadLog-list />

        <b-row>
        <b-col
          cols="12"
          md="12"
          xl="12"
          lg="12"
        >
          <lead-view-source-plan-card :lead-data="leadData" />
        </b-col>
          <b-col
              cols="12"
              md="12"
              xl="12"
              lg="12"
          >
              <lead-view-loan-plan-card :lead-data="leadData" />

          </b-col>
          <b-col
              cols="12"
              md="12"
              xl="12"
              lg="12"
          >
              <lead-view-applicant-plan-card :lead-data="leadData" />


          </b-col>
          <b-col
              cols="12"
              md="12"
              xl="12"
              lg="12"
          >
              <lead-view-residence-plan-card :lead-data="leadData" />


          </b-col>

          <b-col
              cols="12"
              md="12"
              xl="12"
              lg="12"
          >
              <lead-view-employer-plan-card :lead-data="leadData" />


          </b-col>

          <b-col
              cols="12"
              md="12"
              xl="12"
              lg="12"
          >
              <lead-view-consent-plan-card :lead-data="leadData" />


          </b-col>

      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="12"
        >
<!--          <lead-view-user-timeline-card />-->
        </b-col>

      </b-row>

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
import LeadLogList from '@/views/apps/LeadLog/LeadLog-list/LeadLogList.vue'
import ukLeadStoreModule from '../LeadStoreModule'
import LeadViewUserInfoCard from './LeadViewUserInfoCard.vue'
import LeadViewSourcePlanCard from './LeadViewSourcePlanCard.vue'
import LeadViewLoanPlanCard from './LeadViewLoanPlanCard.vue'
import LeadViewApplicantPlanCard from './LeadViewApplicantPlanCard.vue'
import LeadViewEmployerPlanCard from './LeadViewEmployerPlanCard.vue'
import LeadViewResidencePlanCard from './LeadViewResidencePlanCard.vue'
import LeadViewConsentPlanCard from './LeadViewConsentPlanCard.vue'


import LeadViewUserTimelineCard from './LeadViewUserTimelineCard.vue'
import LeadViewUserPermissionsCard from './LeadViewUserPermissionsCard.vue'

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    LeadViewUserInfoCard,
    LeadViewUserTimelineCard,
    LeadViewUserPermissionsCard,

    LeadViewSourcePlanCard,
    LeadViewLoanPlanCard,
    LeadViewApplicantPlanCard,
    LeadViewResidencePlanCard,
    LeadViewEmployerPlanCard,
    LeadViewConsentPlanCard,

    LeadLogList,
  },
  setup() {
    const leadData = ref(null)

    const UKLEAD_APP_STORE_MODULE_NAME = 'app-uk-lead'

    // Register module
    if (!store.hasModule(UKLEAD_APP_STORE_MODULE_NAME)) store.registerModule(UKLEAD_APP_STORE_MODULE_NAME, ukLeadStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(UKLEAD_APP_STORE_MODULE_NAME)) store.unregisterModule(UKLEAD_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-uk-lead/fetchUKLead', { id: router.currentRoute.params.id })
      .then(response => { leadData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          leadData.value = undefined
        }
      })

    return {
      leadData,
    }
  },
}
</script>

<style>

</style>
