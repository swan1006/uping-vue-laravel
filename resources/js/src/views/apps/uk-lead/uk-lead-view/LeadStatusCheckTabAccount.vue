<template>
  <div>

  <b-card>
    <!-- Media -->
    <b-media class="mb-2">
      <h5 class="mb-1">
         Status Logs
      </h5>
    </b-media>

      <b-table
          :striped="true"
          :bordered="true"
          :borderless="true"
          :outlined="true"
          :fields="fields"
          :items="leadLogData.leadlog"
          responsive="sm"

      >
          <!-- A virtual column -->
          <template #cell(index)="data">
              {{ data.item.id }}
          </template>

          <!-- A custom formatted column -->
          <template #cell(lead_id)="data">
              {{ data.item.lead_id }}
          </template>

          <template #cell(buyer_setup_id)="data">
              {{ data.item.buyer_setup_id }}
          </template>

          <template #cell(post_time)="data">
              <span v-if="data.item.post_time >= 30" class="danger"> {{ data.item.post_time }}</span>
              <span v-else-if="data.item.post_time >= 20 && data.item.post_time <= 29" class="warning"> {{ data.item.post_time }}</span>
              <span v-else-if="data.item.post_time >= 10 && data.item.post_time <= 19" class="info"> {{ data.item.post_time }}</span>
              <span v-else-if="data.item.post_time < 9" class="info"> {{ data.item.post_time }}</span>

          </template>

          <template #cell(isredirected)="data">
              <span v-if="data.item.isredirected == 1" class="text-success"> 100%</span>
              <span v-else-if="data.item.isredirected == 0" class="text-danger"> 0%</span>
          </template>
          <template #cell(post_data)="data">

              </b-link>
                     <b-badge pill>
                         View
                     </b-badge>

          </template>
          <template #cell(post_response)="data">
              <b-badge pill>
                  View
              </b-badge>
          </template>

          <!-- A custom formatted column -->
          <template #cell(post_status)="data" >
              <div v-if="data.item.post_status == 0">
                  <b-progress
                      value="100"
                      max="100"
                      :variant="'success'"
                      striped
                  />
                  </div>

              <b-progress
                  v-else-if="data.item.post_status == 0"
                  :value="100"
                  max="100"
                  :variant="'danger'"
                  striped
              />
              <b-progress
                  v-else-if="data.item.post_status == 3"
                  :value="100"
                  max="100"
                  :variant="'warning'"
                  striped
              />
          </template>


          <template #cell(lender_found)="data">
              <b-badge pill variant="primary">
              {{data.item.lender_found}}
              </b-badge>
          </template>

          <!-- A virtual composite column -->
          <template #cell(post_price)="data">
              £ {{ data.item.post_price }}
          </template>

          <!-- Optional default data cell scoped slot -->
<!--          <template #cell()="data">-->
<!--              {{ data.value }}-->
<!--          </template>-->
      </b-table>

<!--      <pre>-->
<!--          {{leadLogData}}-->
<!--      </pre>-->
<!--      <b-row class="mt-5">-->
<!--          <b-button-->
<!--              variant="outline-secondary"-->
<!--              type="reset"-->
<!--              :block="$store.getters['app/currentBreakPoint'] === 'xs'"-->
<!--          >-->
<!--              Back-->
<!--          </b-button>-->
<!--      </b-row>-->
  </b-card>
  </div>

</template>

<script>
    import {
        BButton,
        BMedia,
        BAvatar,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BTab,
        BTabs, BAlert, BLink,
        BProgress, BBadge
    } from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import vSelect from 'vue-select'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import useUKLeadsList from '../uk-lead-list/useLeadList'
import router from '@/router'
import store from '@/store'

export default {
  components: {
    BButton,
    BMedia,
    BAvatar,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BForm,
    BTable,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    vSelect,
      BTab,
      BTabs,
      BCard,
      BAlert,
      BLink,
      BProgress,
      BBadge,
  },

  props: {
    leadData: {
      type: Object,
      required: true,
    },
  },
    data() {
        return {
            fields: [
                // A virtual column that doesn't exist in items
                'index',
                // A column that needs custom formatting
                {key: 'lead_id', label: 'Lead ID'},
                {key: 'buyer_setup_id', label: 'Tier ID'},
                {key: 'post_time', label: 'Post Time'},
                {key: 'isredirected', label: 'Redirected'},
                {key: 'post_data', label: 'Post Data'},
                {key: 'post_response', label: 'Post Resp'},
                // A regular column
                {key: 'post_status', label: 'Post Status'},
                // A regular column
                {key: 'lender_found', label: 'Status'},
                {key: 'reason', label: 'Reason'},
                // A virtual column made up from two fields
                {key: 'post_price', label: 'Price'},
            ],
            // items: [
            //     {
            //         name: {first: 'Lender 1', last: 'Activity Tracker'},
            //         Category: 'Fitness',
            //         post_time: '12 seconds',
            //         reason: 'None provided',order_status: {status: 'Declined', variant: 'danger'},
            //         Status: {value: 100, variant: 'danger'},
            //         price: 59.99,
            //     },
            //     {
            //         name: {first: 'Lender 2 ', last: 'Flex Wireless Activity'},
            //         Category: 'Fitness',
            //             post_time: '12 seconds',
            //         reason: 'None provided',
            //         order_status: {status: 'No Response', variant: 'primary'},
            //         Status: {value: 100, variant: 'primary'},
            //         price: 49.85,
            //     },
            //     {
            //         name: {first: 'Lender 3', last: 'Activity Tracker'},
            //         Category: 'Fitness',
            //             post_time: '12 seconds',
            //         reason: 'None provided',
            //         order_status: {status: 'Declined', variant: 'danger'},
            //         Status: {value: 100, variant: 'danger'},
            //         price: 39.99,
            //     },
            //     {
            //         name: {first: 'Lender 4', last: 'Activity Tracker'},
            //         Category: 'Fitness',
            //             post_time: '12 seconds',
            //         reason: 'None provided',
            //         order_status: {status: 'Accepted', variant: 'success'},
            //         Status: {value: 100, variant: 'success'},
            //         price: 29.99,
            //     },
            //     {
            //         name: {first: 'Lender 5 ', last: 'Flex Wireless Activity'},
            //         Category: 'Fitness',
            //         post_time: '12 seconds',
            //         reason: 'None provided',order_status: {status: 'N/A', variant: 'primary'},
            //         Status: {value: 0, variant: 'primary'},
            //         price: 9.85,
            //     },
            //     {
            //         name: {first: 'Lender 6', last: 'Activity Tracker'},
            //         Category: 'Fitness',
            //         post_time: '12 seconds',
            //         reason: 'None provided',order_status: {status: 'N/A', variant: 'primary'},
            //         Status: {value: 0, variant: 'primary'},
            //         price: 9.99,
            //     },
            // ],
        }
    },
    setup(props) {
    const { resolveUserRoleVariant } = useUKLeadsList()

    const roleOptions = [
      { label: 'Admin', value: 'admin' },
      { label: 'Author', value: 'author' },
      { label: 'Editor', value: 'editor' },
      { label: 'Maintainer', value: 'maintainer' },
      { label: 'Subscriber', value: 'subscriber' },
    ]
    const statusOptions = [
      { label: 'Pending', value: 'pending' },
      { label: 'Active', value: 'active' },
      { label: 'Inactive', value: 'inactive' },
    ]
    const refInputEl = ref(null)
    const previewEl = ref(null)
    const leadLogData = ref(null)
    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.leadData.avatar = base64
    })

        store.dispatch('app-uk-lead/getUkLeadLog', { id: router.currentRoute.params.id })
            .then(response => { leadLogData.value = response.data })
            .catch(error => {
                if (error.response.status === 404) {
                    leadLogData.value = undefined
                }
            })


    return {
      resolveUserRoleVariant,
      avatarText,
      roleOptions,
      statusOptions,

      refInputEl,
      previewEl,
      inputImageRenderer,
      leadLogData,
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
