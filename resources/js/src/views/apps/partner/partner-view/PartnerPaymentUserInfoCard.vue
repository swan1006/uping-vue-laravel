<template>
  <b-card  >

    <b-row>

      <!-- Partner Info: Left col -->


      <b-col
        cols="21"
        xl="6"
        class="d-flex justify-content-between flex-column"
      >
        <!-- Partner Stats -->
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
<!--                  {{ (new Date((partnerData.partner.created_at)).toLocaleDateString('en-US')) }}-->
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
                icon="PartnerIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Payment Info</span>
            </th>
            <td class="pb-50">
                <b-badge class="badge-light-primary">
                    <span class="align-text-top text-capitalize">{{partnerData.partner[0].payment.bank_name}}</span>
                </b-badge>

            </td>
          </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="PartnerIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">Bank Account No.</span>
                </th>
                <td class="pb-50">
                    <b-badge class="badge-light-primary">
                        {{partnerData.partner[0].payment.bank_account_number}}
                    </b-badge>
                </td>
            </tr>
          <tr>
          </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="PartnerIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">IBAN</span>
                </th>
                <td class="pb-50">
                    <b-badge class="badge-light-primary">
                        {{partnerData.partner[0].payment.bank_iban}}
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
                {{partnerData.partner[0].payment.bank_swift}}
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
                    {{partnerData.partner[0].payment.bank_sortcode}}
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
                    {{partnerData.partner[0].company.state}}
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
                    {{partnerData.partner[0].payment.bank_country}}
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
import usePartnersList from '../partner-list/usePartnerList'
import {onUnmounted} from "@vue/composition-api";
import partnerStoreModule from '../PartnerStoreModule';
import store from '@/store';
import usePartnerList from "../partner-list/usePartnerList";


export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar, BBadge
  },
  props: {
    partnerData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {

    const { resolvePartnerRoleVariant, resolvePartnerStatusVariant,goBack } = usePartnersList()


      const PARTNER = 'app-admin-partners'

      // Register module
      if (!store.hasModule(PARTNER)) store.registerModule(PARTNER, partnerStoreModule)

      // UnRegister on leave
      onUnmounted(() => {
          if (store.hasModule(PARTNER)) store.unregisterModule(PARTNER)
      })





      return {
      avatarText,
      resolvePartnerRoleVariant,
      resolvePartnerStatusVariant,
          goBack,
    }
  },
}
</script>

<style>

</style>
