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
                                Company Info
                            </h5>
                            <small>Date Joined</small>
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
                            <span class="font-weight-bold">Email</span>
                        </th>
                        <td class="pb-50">
                            <b-badge class="badge-light-primary">
                                {{partnerData.partner[0].company.email}}
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
                            <b-badge variant="light-primary" v-if="partnerData.partner[0].status == 1">
                                Active
                            </b-badge>
                            <b-badge variant="light-primary" v-else-if="partnerData.partner[0].status == 0">
                                Inactive
                            </b-badge>
                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="CheckIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Postcode</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <span v-if="partnerData.partner[0].company.postcode !== null">
                                                            {{partnerData.partner[0].company.postcode}}
                            </span>
                            <span v-else>
                                         Not available
                            </span>
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
                            <span v-if="partnerData.partner[0].company.state !== null">
                                    {{partnerData.partner[0].company.state}}
                            </span>
                            <span v-else>
                                         Not available
                            </span>

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
                            <span v-if="partnerData.partner[0].company.country !== null">
                                    {{partnerData.partner[0].company.country}}
                            </span>
                            <span v-else>
                                         Not available
                            </span>

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
import usePartnersList from '../partner-list/usePartnerList'

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
  setup() {
    const { resolveBuyerRoleVariant, goBack } = usePartnersList()
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
