<template>

  <div>


    <!-- Filters -->
    <reports-list-filters
      :aff-id-filter.sync="affIdFilter"
      :sub-id-filter.sync="subIdFilter"
      :tier-filter.sync="tierFilter"
      :vid-lead-price-filter.sync="vidLeadPriceFilter"
      :buyer-lead-price-filter.sync="buyerLeadPriceFilter"
      :quality-score-filter.sync="qualityScoreFilter"
      :status-filter.sync="statusFilter"

      :filter-data="filterData"
      :status-options="statusOptions"
      :redirection-options="redirectionOptions"
    />


    <!-- Table Container Card -->
    <b-card
      no-body
      class="mb-0"
    >

      <div class="m-2">

        <!-- Table Top -->
        <b-row>

          <!-- Per Page -->
          <b-col
            cols="12"
            md="6"
            class="d-flex align-items-center justify-content-start mb-1 mb-md-0"
          >
            <label>Show</label>
            <v-select
              v-model="perPage"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="perPageOptions"
              :clearable="false"
              class="per-page-selector d-inline-block mx-50"
            />
            <label>entries</label>
          </b-col>

          <!-- Search -->
          <b-col
            cols="12"
            md="6"
          >
            <div class="d-flex align-items-center justify-content-end">
              <b-form-input
                v-model="searchQuery"
                class="d-inline-block mr-1"
                placeholder="Search..."
              />
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refReportListTable"
        class="position-relative"
        :items="fetchReports"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >

        <!-- Column: vid -->
        <template #cell(vid)="data">
          <b-media vertical-align="center">
            <b-link
              :to="{ name: 'apps-reports-view', params: { id: data.item.id } }"
              class="font-weight-bold d-block text-nowrap"
            >
                <b-badge variant="light-primary">
                    {{ data.item.vid }}

                </b-badge>
            </b-link>
          </b-media>
        </template>


          <!-- Column: subid -->
          <template #cell(subid)="data">
              <b-media vertical-align="center">
                  <b-link
                      :to="{ name: 'apps-reports-view', params: { id: data.item.id } }"
                      class="font-weight-bold d-block text-nowrap"
                  >
                      <b-badge variant="light-primary">
                          {{ data.item.subid }}

                      </b-badge>
                  </b-link>
              </b-media>
          </template>

<!--          tier-->
          <template #cell(tier)="data">
              <b-media vertical-align="center">
                  <b-link
                      :to="{ name: 'apps-reports-view', params: { id: data.item.id } }"
                      class="font-weight-bold d-block text-nowrap"
                  >
                      <b-badge v-if="data.item.tier == 0">
                         ALL Tiers
                      </b-badge>
                      <b-badge v-else>
                          {{ data.item.tier }}
                      </b-badge>
                  </b-link>
              </b-media>
          </template>


          <template #cell(vidLeadPrice)="data">
              <b-media vertical-align="center">
                  <span class="text-success">
                          {{  '£'+data.item.vidLeadPrice }}
                  </span>
              </b-media>
          </template>

          <template #cell(buyerLeadPrice)="data">
              <b-media vertical-align="center">
                  <span class="text-success">
                          {{  '£'+data.item.buyerLeadPrice }}
                  </span>
              </b-media>
          </template>




          <template #cell(isRedirected)="data">
              <b-media vertical-align="center">
                  <span  v-if="data.item.isRedirected === 1">
                          100%
                  </span>
                  <span  v-else-if="data.item.isRedirected === 0">
                          0%
                  </span>
              </b-media>
          </template>

          <template #cell(quality_score)="data">


              <small v-if="data.item.quality_score >= 80" class="align-text-top text-capitalize text-danger">{{data.item.quality_score}}</small>
              <small v-else-if="data.item.quality_score >= 50 && data.item.quality_score <= 79" class="align-text-top text-capitalize text-warning">{{data.item.quality_score}}</small>
              <small v-else-if="data.item.quality_score >= 1 && data.item.quality_score <= 49" class="align-text-top text-capitalize text-secondary">{{data.item.quality_score}}</small>
              <small v-else-if="data.item.quality_score == null" class="align-text-top text-capitalize text-secondary">Not available</small>

          </template>

          <template #cell(leadStatus)="data">
              <b-badge
                  pill
                  :variant="`light-${resolveReportStatusVariant(data.item.leadStatus)}`"
                  class="text-capitalize"
              >
                  <span v-if="data.item.leadStatus == 1">Sold</span>
                  <span v-else-if="data.item.leadStatus == 2">Declined</span>
                  <span v-else-if="data.item.leadStatus == 0">Test</span>
                  <span v-else-if="data.item.leadStatus == 3">Pending</span>
              </b-badge>
          </template>

          <template #cell(actions)="data">
              <b-dropdown
                  variant="link"
                  no-caret
                  :right="$store.state.appConfig.isRTL"
              >

                  <template #button-content>
                      <feather-icon
                          icon="MoreVerticalIcon"
                          size="16"
                          class="align-middle text-body"
                      />
                  </template>
                  <b-dropdown-item :to="{ name: 'apps-uk-leads-view', params: { id: data.item.id } }">
                      <feather-icon icon="FileTextIcon" />
                      <span class="align-middle ml-50">Details</span>
                  </b-dropdown-item>

                  <b-dropdown-item :to="{ name: 'apps-uk-leads-edit', params: { id: data.item.id } }">
                      <feather-icon icon="FileTextIcon" />
                      <span class="align-middle ml-50">Status</span>
                  </b-dropdown-item>

              </b-dropdown>
          </template>

      </b-table>
      <div class="mx-2 mb-2">
        <b-row>

          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-start"
          >
            <span class="text-muted">Showing {{ dataMeta.from }} to {{ dataMeta.to }} of {{ dataMeta.of }} entries</span>
          </b-col>
          <!-- Pagination -->
          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-end"
          >

            <b-pagination
              v-model="currentPage"
              :total-rows="totalReports"
              :per-page="perPage"
              first-number
              last-number
              class="mb-0 mt-1 mt-sm-0"
              prev-class="prev-item"
              next-class="next-item"
            >
              <template #prev-text>
                <feather-icon
                  icon="ChevronLeftIcon"
                  size="18"
                />
              </template>
              <template #next-text>
                <feather-icon
                  icon="ChevronRightIcon"
                  size="18"
                />
              </template>
            </b-pagination>

          </b-col>

        </b-row>
      </div>
    </b-card>
  </div>
</template>

<script>
import {
  BCard,
  BRow,
  BCol,
  BFormInput,
  BButton,
  BTable,
  BMedia,
  BAvatar,
  BLink,
  BBadge,
  BDropdown,
  BDropdownItem,
  BPagination,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import store from '@/store'
import { ref, onUnmounted } from '@vue/composition-api'
import { avatarText } from '@core/utils/filter'
import ReportsListFilters from './ReportListFilters.vue'
import useReportsList from './useReportList'
import reportStoreModule from '../ReportStoreModule'

export default {
  components: {
    ReportsListFilters,

    BCard,
    BRow,
    BCol,
    BFormInput,
    BButton,
    BTable,
    BMedia,
    BAvatar,
    BLink,
    BBadge,
    BDropdown,
    BDropdownItem,
    BPagination,

    vSelect,
  },
    created() {


    },
    setup() {
        const filterData = ref({});
        const REPORT = 'app-report'

        // Register module
        if (!store.hasModule(REPORT)) store.registerModule(REPORT, reportStoreModule)

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(REPORT)) store.unregisterModule(REPORT)
        })

        const isAddNewReportSidebarActive = ref(false)

        const roleOptions = [
            {label: 'Admin', value: 'admin'},
            {label: 'Author', value: 'author'},
            {label: 'Editor', value: 'editor'},
            {label: 'Maintainer', value: 'maintainer'},
            {label: 'Subscriber', value: 'subscriber'},
        ]
        const planOptions = [
            {label: 'Basic', value: 'basic'},
            {label: 'Company', value: 'company'},
            {label: 'Enterprise', value: 'enterprise'},
            {label: 'Team', value: 'team'},
        ]


        store.dispatch('app-report/fetchFilterData')
            .then(response => {
                console.log(response.data)
                debugger
                filterData.value = response.data
            })
            .catch(error => {
                console.log(error)
                filterData.value = undefined
                // if (error.response.status === 404) {
                //     filterData.value = undefined
                // }
            })



    const {
      fetchReports,
      tableColumns,
      perPage,
      currentPage,
      totalReports,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refReportListTable,
      refetchData,

      // UI
      resolveReportRoleVariant,
      resolveReportRoleIcon,
      resolveReportStatusVariant,

      // Extra Filters
        affIdFilter,
        subIdFilter,
        tierFilter,
        vidLeadPriceFilter,
        buyerLeadPriceFilter,
        qualityScoreFilter,
        statusFilter,

        // Filter Options
        statusOptions,
        redirectionOptions,

    } = useReportsList()

    return {
      // Sidebar
      isAddNewReportSidebarActive,

      fetchReports,
      tableColumns,
      perPage,
      currentPage,
      totalReports,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refReportListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolveReportRoleVariant,
      resolveReportRoleIcon,
      resolveReportStatusVariant,

      roleOptions,
      planOptions,
      statusOptions,
      redirectionOptions,
      // Filter Data
      filterData,

      // Extra Filters
        affIdFilter,
        subIdFilter,
        tierFilter,
        vidLeadPriceFilter,
        buyerLeadPriceFilter,
        qualityScoreFilter,
        statusFilter,
    }
  },
}
</script>

<style lang="scss" scoped>
.per-page-selector {
  width: 90px;
}
</style>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
