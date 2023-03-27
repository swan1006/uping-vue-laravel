<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="userData === undefined"
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

    <template v-if="userData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="12"
          lg="12"
          md="12"
        >
          <user-view-user-info-card :user-data="userData" />
        </b-col>

      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
        <user-company-user-info-card :user-data="userData" />

        </b-col>
        <b-col
          cols="12"
          lg="6"
        >
            <user-payment-user-info-card :user-data="userData" />

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
  BRow, BCol, BAlert, BLink, BBadge
} from 'bootstrap-vue'
import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
import userStoreModule from '../UserStoreModule'
import UserViewUserInfoCard from './UserViewUserInfoCard.vue'
import UserCompanyUserInfoCard from './UserCompanyUserInfoCard.vue'
import UserPaymentUserInfoCard from './UserPaymentUserInfoCard.vue'
import UserViewUserPlanCard from './UserViewUserPlanCard.vue'
import UserViewUserTimelineCard from './UserViewUserTimelineCard.vue'
import UserViewUserPermissionsCard from './UserViewUserPermissionsCard.vue'

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,
    BBadge,

    // Local Components
    UserViewUserInfoCard,
    UserCompanyUserInfoCard,
    UserPaymentUserInfoCard,
    UserViewUserPlanCard,
    UserViewUserTimelineCard,
    UserViewUserPermissionsCard,

    InvoiceList,
  },
  setup() {
    const userData = ref(null)

    const USERS = 'app-users'

    // Register module
    if (!store.hasModule(USERS)) store.registerModule(USERS, userStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USERS)) store.unregisterModule(USERS)
    })

    store.dispatch('app-users/fetchUser', { id: router.currentRoute.params.id })
      .then(response => { userData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          userData.value = undefined
        }
      })

    return {
      userData,
    }
  },
}
</script>

<style>

</style>
