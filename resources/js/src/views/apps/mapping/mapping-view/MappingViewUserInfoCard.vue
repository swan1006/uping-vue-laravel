<template>
  <b-card  >

    <b-row>

      <!-- Mapping Info: Left col -->
      <b-col
        cols="21"
        xl="6"
        class="d-flex justify-content-between flex-column"
      >
        <!-- Mapping Avatar & Action Buttons -->
        <div class="d-flex justify-content-start">
          <b-avatar
            :variant="`light-${resolveMappingRoleVariant(mappingData.role)}`"
            size="104px"
            rounded
          />
          <div class="d-flex flex-column ml-1">
            <div class="mb-1">
              <h4 class="mb-0">
                {{ mappingData.mapping.partner[0].vendor_id }}
              </h4>
<!--              <span class="card-text">{{ mappingData.email }}</span>-->
            </div>
              <div class="d-flex flex-wrap">
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
              <span class="font-weight-bold">Active Mapping Count</span>
            </th>
            <td class="pb-50">
                <b-badge variant="light-primary">
                    {{ mappingData.mapping.mappings_count }} Active Tiers
                </b-badge>

            </td>
          </tr>
          <tr>
<!--            <th class="pb-50">-->
<!--              <feather-icon-->
<!--                icon="CheckIcon"-->
<!--                class="mr-75"-->
<!--              />-->
<!--              <span class="font-weight-bold">Status</span>-->
<!--            </th>-->
<!--            <td class="pb-50 text-capitalize">-->
<!--                <b-badge v-if="mappingData.mapping.status === 1" variant="light-success">-->
<!--                    Active-->
<!--                </b-badge>-->
<!--                <b-badge  v-else-if="mappingData.mapping.status === 0" variant="light-primary">-->
<!--                    Inactive-->
<!--                </b-badge>-->
<!--            </td>-->
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
import useMappingsList from '../mapping-list/useMappingList'

export default {
  components: {
    BCard, BButton, BRow, BCol, BAvatar,BBadge
  },
  props: {
    mappingData: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const { resolveMappingRoleVariant, goBack } = useMappingsList()
    return {
      avatarText,
      resolveMappingRoleVariant,
        goBack
    }
  },
}
</script>

<style>

</style>
