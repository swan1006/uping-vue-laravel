<!--<template>-->
<!--  <div>-->

<!--      <component :is="leadData === undefined ? 'div' : 'b-card'">-->

<!--          &lt;!&ndash; Alert: No item found &ndash;&gt;-->
<!--          <b-alert-->
<!--              variant="danger"-->
<!--              :show="leadData === undefined"-->
<!--          >-->
<!--              <h4 class="alert-heading">-->
<!--                  Error fetching lead data-->
<!--              </h4>-->
<!--              <div class="alert-body">-->
<!--                  No lead found with this lead id. Check-->
<!--                  <b-link-->
<!--                      class="alert-link"-->
<!--                      :to="{ name: 'apps-leads-list'}"-->
<!--                  >-->
<!--                      Buyer List-->
<!--                  </b-link>-->
<!--                  for other leads.-->
<!--              </div>-->
<!--          </b-alert>-->

<!--          <b-tabs-->
<!--              v-if="leadData"-->
<!--              pills-->
<!--          >-->

<!--              &lt;!&ndash; Tab: Account &ndash;&gt;-->
<!--              <b-tab active>-->
<!--                  <template #title>-->
<!--                      <feather-icon-->
<!--                          icon="BuyerIcon"-->
<!--                          size="16"-->
<!--                          class="mr-0 mr-sm-50"-->
<!--                      />-->
<!--                      <span class="d-none d-sm-inline">Account</span>-->
<!--                  </template>-->
<!--                  <lead-view-applicant-plan-card-->
<!--                      :lead-data="leadData"-->
<!--                      class="mt-2 pt-75"-->
<!--                  />-->
<!--              </b-tab>-->

<!--              &lt;!&ndash; Tab: Information &ndash;&gt;-->
<!--              <b-tab>-->
<!--                  <template #title>-->
<!--                      <feather-icon-->
<!--                          icon="InfoIcon"-->
<!--                          size="16"-->
<!--                          class="mr-0 mr-sm-50"-->
<!--                      />-->
<!--                      <span class="d-none d-sm-inline">Information</span>-->
<!--                  </template>-->
<!--                  <lead-edit-tab-information class="mt-2 pt-75" />-->
<!--              </b-tab>-->

<!--              &lt;!&ndash; Tab: Social &ndash;&gt;-->
<!--              <b-tab>-->
<!--                  <template #title>-->
<!--                      <feather-icon-->
<!--                          icon="Share2Icon"-->
<!--                          size="16"-->
<!--                          class="mr-0 mr-sm-50"-->
<!--                      />-->
<!--                      <span class="d-none d-sm-inline">Social</span>-->
<!--                  </template>-->
<!--                  <lead-edit-tab-social class="mt-2 pt-75" />-->
<!--              </b-tab>-->
<!--          </b-tabs>-->
<!--      </component>-->


<!--    <template v-if="leadData">-->
<!--      &lt;!&ndash; First Row &ndash;&gt;-->
<!--      <b-row>-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          xl="12"-->
<!--          lg="12"-->
<!--          md="12"-->
<!--        >-->
<!--          <lead-view-user-info-card :lead-data="leadData" />-->
<!--        </b-col>-->
<!--      </b-row>-->
<!--        <LeadLog-list />-->

<!--        <b-row>-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          md="12"-->
<!--          xl="12"-->
<!--          lg="12"-->
<!--        >-->
<!--&lt;!&ndash;          <lead-view-source-plan-card :lead-data="leadData" />&ndash;&gt;-->
<!--        </b-col>-->
<!--          <b-col-->
<!--              cols="12"-->
<!--              md="12"-->
<!--              xl="12"-->
<!--              lg="12"-->
<!--          >-->
<!--&lt;!&ndash;              <lead-view-loan-plan-card :lead-data="leadData" />&ndash;&gt;-->

<!--          </b-col>-->
<!--          <b-col-->
<!--              cols="12"-->
<!--              md="12"-->
<!--              xl="12"-->
<!--              lg="12"-->
<!--          >-->
<!--&lt;!&ndash;              <lead-view-applicant-plan-card :lead-data="leadData" />&ndash;&gt;-->


<!--          </b-col>-->
<!--          <b-col-->
<!--              cols="12"-->
<!--              md="12"-->
<!--              xl="12"-->
<!--              lg="12"-->
<!--          >-->
<!--&lt;!&ndash;              <lead-view-residence-plan-card :lead-data="leadData" />&ndash;&gt;-->


<!--          </b-col>-->

<!--          <b-col-->
<!--              cols="12"-->
<!--              md="12"-->
<!--              xl="12"-->
<!--              lg="12"-->
<!--          >-->
<!--&lt;!&ndash;              <lead-view-employer-plan-card :lead-data="leadData" />&ndash;&gt;-->


<!--          </b-col>-->

<!--          <b-col-->
<!--              cols="12"-->
<!--              md="12"-->
<!--              xl="12"-->
<!--              lg="12"-->
<!--          >-->
<!--&lt;!&ndash;              <lead-view-consent-plan-card :lead-data="leadData" />&ndash;&gt;-->


<!--          </b-col>-->

<!--      </b-row>-->

<!--      <b-row>-->
<!--        <b-col-->
<!--          cols="12"-->
<!--          lg="12"-->
<!--        >-->
<!--&lt;!&ndash;          <lead-view-user-timeline-card />&ndash;&gt;-->
<!--        </b-col>-->

<!--      </b-row>-->

<!--    </template>-->

<!--  </div>-->
<!--</template>-->

<template>
    <component :is="leadData === undefined ? 'div' : 'b-card'">

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
                    :to="{ name: 'apps-leads-list'}"
                >
                    Lead Data
                </b-link>
                for other leads.
            </div>
        </b-alert>

        <b-tabs
            v-if="leadData"
            pills
        >

            <b-tab active>
                <template #title>
                    <feather-icon
                        icon="BuyerIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Lead Overview</span>
                </template>
                <lead-applicant-tab-account
                    :lead-data="leadData"
                    class="mt-2 pt-75"
                />
            </b-tab>
            <b-tab >
                <template #title>
                    <feather-icon
                        icon="BuyerIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Status Check</span>
                </template>
                <lead-status-check-tab-account
                    :lead-data="leadData"
                    class="mt-2 pt-75"
                />
            </b-tab>
            <b-tab >
                <template #title>
                    <feather-icon
                        icon="BuyerIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Residence</span>
                </template>
                <lead-residence-tab-account
                    :lead-data="leadData"
                    class="mt-2 pt-75"
                />
            </b-tab>

<!--            &lt;!&ndash; Tab: Account &ndash;&gt;-->
<!--            <b-tab >-->
<!--                <template #title>-->
<!--                    <feather-icon-->
<!--                        icon="BuyerIcon"-->
<!--                        size="16"-->
<!--                        class="mr-0 mr-sm-50"-->
<!--                    />-->
<!--                    <span class="d-none d-sm-inline">Applicant</span>-->
<!--                </template>-->
<!--                <lead-applicant-tab-account-->
<!--                    :lead-data="leadData"-->
<!--                    class="mt-2 pt-75"-->
<!--                />-->
<!--            </b-tab>-->

<!--            &lt;!&ndash; Tab: Account &ndash;&gt;-->
<!--            <b-tab >-->
<!--                <template #title>-->
<!--                    <feather-icon-->
<!--                        icon="BuyerIcon"-->
<!--                        size="16"-->
<!--                        class="mr-0 mr-sm-50"-->
<!--                    />-->
<!--                    <span class="d-none d-sm-inline">Loan</span>-->
<!--                </template>-->
<!--                <lead-applicant-tab-account-->
<!--                    :lead-data="leadData"-->
<!--                    class="mt-2 pt-75"-->
<!--                />-->
<!--            </b-tab>-->
<!--            &lt;!&ndash; Tab: Account &ndash;&gt;-->
<!--            <b-tab >-->
<!--                <template #title>-->
<!--                    <feather-icon-->
<!--                        icon="BuyerIcon"-->
<!--                        size="16"-->
<!--                        class="mr-0 mr-sm-50"-->
<!--                    />-->
<!--                    <span class="d-none d-sm-inline">Source</span>-->
<!--                </template>-->
<!--                <lead-applicant-tab-account-->
<!--                    :lead-data="leadData"-->
<!--                    class="mt-2 pt-75"-->
<!--                />-->
<!--            </b-tab>-->
<!--            &lt;!&ndash; Tab: Account &ndash;&gt;-->
<!--            <b-tab >-->
<!--                <template #title>-->
<!--                    <feather-icon-->
<!--                        icon="BuyerIcon"-->
<!--                        size="16"-->
<!--                        class="mr-0 mr-sm-50"-->
<!--                    />-->
<!--                    <span class="d-none d-sm-inline">Residence</span>-->
<!--                </template>-->
<!--                <lead-applicant-tab-account-->
<!--                    :lead-data="leadData"-->
<!--                    class="mt-2 pt-75"-->
<!--                />-->
<!--            </b-tab>-->
<!--            &lt;!&ndash; Tab: Account &ndash;&gt;-->
<!--            <b-tab >-->
<!--                <template #title>-->
<!--                    <feather-icon-->
<!--                        icon="BuyerIcon"-->
<!--                        size="16"-->
<!--                        class="mr-0 mr-sm-50"-->
<!--                    />-->
<!--                    <span class="d-none d-sm-inline">Bank</span>-->
<!--                </template>-->
<!--                <lead-applicant-tab-account-->
<!--                    :lead-data="leadData"-->
<!--                    class="mt-2 pt-75"-->
<!--                />-->
<!--            </b-tab>-->
<!--            &lt;!&ndash; Tab: Account &ndash;&gt;-->
<!--            <b-tab >-->
<!--                <template #title>-->
<!--                    <feather-icon-->
<!--                        icon="BuyerIcon"-->
<!--                        size="16"-->
<!--                        class="mr-0 mr-sm-50"-->
<!--                    />-->
<!--                    <span class="d-none d-sm-inline">Consent</span>-->
<!--                </template>-->
<!--                <lead-applicant-tab-account-->
<!--                    :lead-data="leadData"-->
<!--                    class="mt-2 pt-75"-->
<!--                />-->
<!--            </b-tab>-->
            <!-- Tab: Account -->


        </b-tabs>
    </component>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { ref, onUnmounted } from '@vue/composition-api'
import {
    BRow, BCol, BAlert, BLink, BTab,
    BTabs, BCard,

} from 'bootstrap-vue'
import LeadLogList from '@/views/apps/LeadLog/LeadLog-list/LeadLogList.vue'
import ukLeadStoreModule from '../LeadStoreModule'
import LeadViewUserInfoCard from './LeadViewUserInfoCard.vue'
// import LeadViewSourcePlanCard from './LeadViewSourcePlanCard.vue'
// import LeadViewLoanPlanCard from './LeadViewLoanPlanCard.vue'
// import LeadViewApplicantPlanCard from './LeadViewApplicantPlanCard.vue'
// import LeadViewEmployerPlanCard from './LeadViewEmployerPlanCard.vue'
// import LeadViewResidencePlanCard from './LeadViewResidencePlanCard.vue'
// import LeadViewConsentPlanCard from './LeadViewConsentPlanCard.vue'


import LeadStatusCheckTabAccount from './LeadStatusCheckTabAccount.vue'



export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,
      BTab,
      BTabs,
      BCard,

      // Local Components
    LeadViewUserInfoCard,

    LeadStatusCheckTabAccount,




    LeadLogList,
  },
  setup() {
    const leadData = ref(null)

    const UK_LEADS = 'app-uk-lead'

    // Register module
    if (!store.hasModule(UK_LEADS)) store.registerModule(UK_LEADS, ukLeadStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(UK_LEADS)) store.unregisterModule(UK_LEADS)
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
