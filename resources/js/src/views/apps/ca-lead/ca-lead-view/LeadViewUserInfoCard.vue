<template>
    <b-card  >


    <b-row>

      <!-- Buyer Info: Left col -->
      <b-col
        cols="21"
        xl="6"
        class="d-flex justify-content-between flex-column"
      >
        <!-- Buyer Avatar & Action Buttons -->
        <div class="d-flex justify-content-start">
          <div class="d-flex flex-column ml-1">
            <div class="mb-1">
              <h4 class="mb-0">
                {{ leadData.lead.vid }}
              </h4>
              <small class="card-text">LEAD ID: {{ leadData.lead.id }}</small>

            </div>
          </div>
        </div>

        <!-- Buyer Stats -->
        <div class="d-flex align-items-center mt-2">
          <div class="d-flex align-items-center mr-2">
            <b-avatar
              variant="light-primary"
              rounded
            >
              <feather-icon
                icon="DollarSignIcon"
                size="18"
              />
            </b-avatar>
            <div class="ml-1">
              <h5 class="mb-0">
                £ {{ leadData.lead.vidLeadPrice }}
              </h5>
              <small>Lead Price</small>
            </div>
          </div>

          <div class="d-flex align-items-center">
            <b-avatar
              variant="light-success"
              rounded
            >
              <feather-icon
                icon="TrendingUpIcon"
                size="18"
              />
            </b-avatar>
            <div class="ml-1">
              <h5 class="mb-0">
                £2.50
              </h5>
              <small>Profit</small>
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
              <span class="font-weight-bold">Transaction ID</span>
            </th>
            <td class="pb-50">
                <b-badge variant="light-primary">
                    {{ leadData.lead.transaction_id }}
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
                <b-badge v-if="leadData.lead.leadStatus === 1" variant="light-primary">
                    Active
                </b-badge>
                <b-badge  v-else-if="leadData.lead.leadStatus === 2" variant="light-primary">
                    Paused
                </b-badge>
                <b-badge  v-else-if="leadData.lead.leadStatus === 0" variant="light-primary">
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
              <span class="font-weight-bold">Redirection</span>
            </th>
            <td class="pb-50 text-capitalize">
                <b-badge v-if="leadData.lead.isRedirected === 1" variant="light-success">
                    100%
                </b-badge>
                <b-badge  v-else-if="leadData.lead.isRedirected === 2" variant="light-warning">
                    0%
                </b-badge>


            </td>
          </tr>
          <tr>
            <th class="pb-50">
              <feather-icon
                icon="FlagIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Offer ID</span>
            </th>
            <td class="pb-50">
                <b-badge variant="light-primary">
                {{ leadData.lead.oid }}
                </b-badge>
            </td>
          </tr>
          <tr>
            <th>
              <feather-icon
                icon="UserIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Tier</span>
            </th>
            <td>
                <b-badge variant="light-primary">
                {{ leadData.lead.tier }}
                </b-badge>
            </td>
          </tr>
        </table>
      </b-col>
    </b-row>
  </b-card>
</template>

<script>
import {
  BCard, BButton, BAvatar, BRow, BCol, BBadge
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import useLeadsList from '../ca-lead-list/useLeadList'

export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar, BBadge
  },
  props: {
    leadData: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const { resolveBuyerRoleVariant } = useLeadsList()
    return {
      avatarText,
      resolveBuyerRoleVariant,
    }
  },
}
</script>

<style>

</style>
