<template>
  <b-card  >

    <b-row>

      <!-- Advertiser Info: Left col -->
        <b-col
            cols="21"
            xl="6"
            class="d-flex justify-content-between flex-column"
        >
            <!-- Advertiserr Avatar & Action Buttons -->
            <div class="d-flex justify-content-start">
                <b-avatar
                    size="104px"
                    rounded
                />
                <div class="d-flex flex-column ml-1">
                    <div class="mb-1">
                        <h4 class="mb-0">
                            {{ advertiserData.advertiser.company.name }}
                        </h4>
                        <span class="card-text"></span>
                    </div>
                    <div class="d-flex flex-wrap">
                        <b-button
                            :to="{ name: 'apps-advertisers-edit', params: { id: advertiserData.advertiser.id } }"
                            variant="primary"
                            :advertiser-data="advertiserData"
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

        <!-- Advertiser Stats -->
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
                23.3k
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
              <span class="font-weight-bold">Name</span>
            </th>
            <td class="pb-50">
                <b-badge  variant="light-primary">
                    {{ advertiserData.advertiser.company.name }}
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
                <b-badge v-if="advertiserData.advertiser.status === 1" variant="light-success">
                    Active
                </b-badge>
                <b-badge  v-else-if="advertiserData.advertiser.status === 2" variant="light-primary">
                    Paused
                </b-badge>
                <b-badge  v-else-if="advertiserData.advertiser.status === 0" variant="light-primary">
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
              <span class="font-weight-bold">Website</span>
            </th>
            <td class="pb-50 text-capitalize">
                <b-badge  variant="light-primary">

                {{ advertiserData.advertiser.company.website }}
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
import useAdvertisersList from '../advertiser-list/useAdvertiserList'

export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar, BBadge
  },
  props: {
    advertiserData: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const { resolveAdvertiserRoleVariant,goBack } = useAdvertisersList()
    return {
      avatarText,
      resolveAdvertiserRoleVariant,
        advertiserData,
        goBack

    }
  },
}
</script>

<style>

</style>
