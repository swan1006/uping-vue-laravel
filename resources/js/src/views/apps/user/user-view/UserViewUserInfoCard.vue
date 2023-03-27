<template>
  <b-card  >

    <b-row>

      <!-- User Info: Left col -->


        <b-col
            cols="21"
            xl="6"
            class="d-flex justify-content-between flex-column"
        >
        <!-- User Avatar & Action Buttons -->
        <div class="d-flex justify-content-start">
          <b-avatar
            :src="userData.user.avatar"
            :text="avatarText(userData.user.name)"
            :variant="`light-${resolveUserRoleVariant(userData.user.role)}`"
            size="104px"
            rounded
          />
          <div class="d-flex flex-column ml-1">
            <div class="mb-1">
              <h4 class="mb-0">
                {{ userData.user.name }}
              </h4>
              <span class="card-text">{{ userData.user.email }}</span>
            </div>
            <div class="d-flex flex-wrap">
              <b-button
                :to="{ name: 'apps-users-edit', params: { id: userData.user.id } }"
                variant="primary"
              >
                Edit
              </b-button>
              <b-button
                variant="outline-primary"
                class="ml-1"
                @click="goBack"
              >
                Back
              </b-button>
            </div>
          </div>
        </div>

        </b-col>





      <!-- Right Col: Table -->
          <b-col
        cols="12"
        xl="6"
      >
        <table class="mt-2 mt-xl-0 w-100">
          <tr>
            <th class="pb-50">
              <feather-icon
                icon="UserIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Contact</span>
            </th>
            <td class="pb-50">
                <b-badge class="badge-light-primary">
                    <span class="align-text-top text-capitalize">{{ userData.user.username }}</span>
                </b-badge>

            </td>
          </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="UserIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">Email</span>
                </th>
                <td class="pb-50">
                    <b-badge class="badge-light-primary">

                    {{ userData.user.email }}
                    </b-badge>
                </td>
            </tr>
          <tr>
          </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="UserIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">Skype</span>
                </th>
                <td class="pb-50">
                    <b-badge class="badge-light-primary">

                    {{ userData.user.company.skype ? userData.user.company.skype : 'Not available'}}
                    </b-badge>

                </td>
            </tr>
            <tr>
            <th class="pb-50">
              <feather-icon
                icon="CheckIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Status</span>
            </th>
            <td class="pb-50 text-capitalize">
                <b-badge v-if="userData.user.status === 1" variant="light-primary">
                    Active
                </b-badge>
                <b-badge  v-else-if="userData.user.status === 2" variant="light-warning">
                    Paused
                </b-badge>
                <b-badge  v-else-if="userData.user.status === 3" variant="light-secondary">
                    Inactive
                </b-badge>
            </td>
          </tr>
          <tr>
            <th class="pb-50">
              <feather-icon
                icon="StarIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Role</span>
            </th>
            <td class="pb-50 text-capitalize">
                <b-badge v-if="userData.user.role === 1" variant="light-primary">
                    Admin
                </b-badge>
                <b-badge  v-else-if="userData.user.role === 2" variant="light-warning">
                    Staff
                </b-badge>
                <b-badge  v-else-if="userData.user.role === 3" variant="light-secondary">
                    Partner
                </b-badge>
                <b-badge  v-else-if="userData.user.role === 3" variant="light-secondary">
                    Buyer
                </b-badge>


            </td>
          </tr>

          <tr>
            <th>
              <feather-icon
                icon="PhoneIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Dated Joined</span>
            </th>
            <td>
             {{ userData.user.created_at }}
            </td>
          </tr>
        </table>
      </b-col>
    </b-row>
  </b-card>


</template>


<script>
import {
  BCard, BButton, BAvatar, BRow, BCol,BBadge
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import useUsersList from '../user-list/useUserList'
import {onUnmounted} from "@vue/composition-api";
import userStoreModule from '../UserStoreModule';
import store from '@/store';
import useUserList from "../user-list/useUserList";


export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar, BBadge
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {

    const { resolveUserRoleVariant, resolveUserStatusVariant,goBack } = useUsersList()


      const USERS = 'app-users'

      // Register module
      if (!store.hasModule(USERS)) store.registerModule(USERS, userStoreModule)

      // UnRegister on leave
      onUnmounted(() => {
          if (store.hasModule(USERS)) store.unregisterModule(USERS)
      })





      return {
      avatarText,
      resolveUserRoleVariant,
      resolveUserStatusVariant,
          goBack,
    }
  },
}
</script>

<style>

</style>
