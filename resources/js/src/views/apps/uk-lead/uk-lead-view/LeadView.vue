<template>
    <div>

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="leadData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching user data
            </h4>
            <div class="alert-body">
                No user found with this user id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-users-list'}"
                >
                    User List
                </b-link>
                for other users.
            </div>
        </b-alert>

        <template v-if="leadData">
            <!-- First Row -->
            <b-row>
                <b-col
                    cols="12"
                    lg="12"
                >
                    <lead-view-user-info-card :lead-data="leadData" />

                </b-col>

            </b-row>
            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                >
                    <lead-status-check-tab-account :lead-data="leadData" />

                </b-col>
            </b-row>

            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                >
                    <lead-overview-tab-account :lead-data="leadData" />
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
    BRow, BCol, BAlert, BLink, BTab,
    BTabs, BCard,

} from 'bootstrap-vue'
import LeadLogList from '@/views/apps/LeadLog/LeadLog-list/LeadLogList.vue'
import ukLeadStoreModule from '../LeadStoreModule'

import LeadOverviewTabAccount from './LeadOverviewTabAccount.vue'
import LeadViewUserInfoCard from './LeadViewUserInfoCard.vue'
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

    LeadOverviewTabAccount,
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
