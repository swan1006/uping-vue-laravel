<template>
  <b-card >

    <b-row>

      <!-- Buyer Info: Left col -->
      <b-col
        cols="21"
        xl="6"
        class="d-flex justify-content-between flex-column"
      >
        <!-- Buyer Avatar & Action Buttons -->
        <div class="d-flex justify-content-start">
          <b-avatar
            :src="buyerData.buyer.avatar"
            :text="avatarText(buyerData.buyer.company.name)"
            :variant="`light-${resolveBuyerRoleVariant(buyerData.role)}`"
            size="104px"
            rounded
          />
          <div class="d-flex flex-column ml-1">
            <div class="mb-1">
              <h4 class="mb-0">
                {{ buyerData.buyer.company.name }}
              </h4>
              <span class="card-text">{{ buyerData.email }}</span>
            </div>
            <div class="d-flex flex-wrap">
              <b-button
                :to="{ name: 'apps-buyers-edit', params: { id: buyerData.buyer.id } }"
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
                £5500
              </h5>
              <small>Monthly Sales</small>
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
                £99.87k
              </h5>
              <small>Annual Profit</small>
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
              <span class="font-weight-bold">Buyer</span>
            </th>
            <td class="pb-50">
                <b-badge variant="light-primary">
                    {{ buyerData.buyer.company.name }}
                </b-badge>

            </td>
          </tr>
            <tr>
                <th class="pb-50">
                    <feather-icon
                        icon="UserIcon"
                        class="mr-75"
                    />
                    <span class="font-weight-bold">Buyer ID</span>
                </th>
                <td class="pb-50">
                    <b-badge variant="light-primary">
                        LEND_513
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
                <b-badge v-if="buyerData.buyer.status === 1" variant="light-success">
                    Active
                </b-badge>
                <b-badge  v-else-if="buyerData.buyer.status === 0" variant="light-primary">
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
              <span class="font-weight-bold">Buyer Type</span>
            </th>
            <td class="pb-50 text-capitalize">
                <b-badge v-if="buyerData.buyer.buyer_type === '1'" variant="light-primary">
                    Lender
                </b-badge>
                <b-badge  v-else-if="buyerData.buyer.buyer_type === '2'" variant="light-primary">
                    Broker
                </b-badge>
                <b-badge  v-else-if="buyerData.buyer.buyer_type === '3'" variant="light-primary">
                    Inactive
                </b-badge>
            </td>
          </tr>
          <tr>
            <th class="pb-50">
              <feather-icon
                icon="FlagIcon"
                class="mr-75"
              />
              <span class="font-weight-bold">Tree</span>
            </th>
            <td class="pb-50">
                <b-badge v-if="buyerData.buyer.company.country === 'UK'" variant="light-primary">
                    UK
                </b-badge>
                <b-badge  v-else-if="buyerData.buyer.company.country === 'USA'" variant="light-primary">
                    US
                </b-badge>
              {{ buyerData.country }}
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
import useBuyersList from '../buyer-list/useBuyerList'

export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar, BBadge
  },
  props: {
    buyerData: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const { resolveBuyerRoleVariant, goBack } = useBuyersList()
    return {
      avatarText,
      resolveBuyerRoleVariant,
        goBack,
    }
  },
}
</script>

<style>

</style>
