<template>
  <b-card  >

    <b-row>

      <!-- User Info: Left col -->


      <b-col
        cols="21"
        xl="6"
        class="d-flex justify-content-between flex-column"
      >
        <!-- User Stats -->
        <div class="d-flex align-items-center mt-2">
          <div class="d-flex align-items-center mr-2">
            <b-avatar
              variant="light-primary"
              rounded
            >
              <feather-icon
                icon="CalenderSignIcon"
                size="18"
              />
            </b-avatar>
            <div class="ml-1">
              <h5 class="mb-0">
<!--                  {{ (new Date((userData.user.created_at)).toLocaleDateString('en-US')) }}-->
                  Payment Info
              </h5>
              <small></small>
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
              <span class="font-weight-bold">Payment Info</span>
            </th>
            <td class="pb-50">
                <b-badge class="badge-light-primary">
                    <span class="align-text-top text-capitalize">{{userData.user.payment.bank_name}}</span>
                </b-badge>

            </td>
          </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="UserIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">Bank Account No.</span>
                </th>
                <td class="pb-50">
                    <b-badge class="badge-light-primary">
                        {{userData.user.payment.bank_account_number}}
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
                    <span class="font-weight-bold">IBAN</span>
                </th>
                <td class="pb-50">
                    <b-badge class="badge-light-primary">
                        {{userData.user.payment.bank_iban}}
                    </b-badge>

                </td>
            </tr>
            <tr>
            <th class="pb-50">
              <feather-icon
                icon="CheckIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">SWIFT</span>
            </th>
            <td class="pb-50 text-capitalize">
                {{userData.user.payment.bank_swift}}
            </td>
          </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="CheckIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">Sortcode</span>
                </th>
                <td class="pb-50 text-capitalize">
                    {{userData.user.payment.bank_sortcode}}
                </td>
            </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="CheckIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">State</span>
                </th>
                <td class="pb-50 text-capitalize">
                    {{userData.user.payment.state}}
                </td>
            </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="CheckIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">Country</span>
                </th>
                <td class="pb-50 text-capitalize">
                    {{userData.user.payment.country}}
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


      const USER_APP_STORE_MODULE_NAME = 'app-users'

      // Register module
      if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, userStoreModule)

      // UnRegister on leave
      onUnmounted(() => {
          if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
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
