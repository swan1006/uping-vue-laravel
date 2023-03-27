<template>

  <div>

<!--    <report-list-add-new-->
<!--      :is-add-new-report-sidebar-active.sync="isAddNewReportSidebarActive"-->
<!--      :affId-options="affIdOptions"-->
<!--      :conversion-options="conversionOptions"-->
<!--      @refetch-data="refetchData"-->
<!--    />-->

    <!-- Filters -->
    <reports-list-filters
      :aff-id-filter.sync="affIdFilter"
      :conversion-filter.sync="conversionFilter"
      :status-filter.sync="statusFilter"

      :conversion-options="conversionOptions"
      :filter-data="filterData"
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


          <template #cell(offer_id)="data">
              <b-media vertical-align="center">
                  <b-link
                      :to="{ name: 'apps-report-offer-view', params: { id: data.item.id } }"
                      class="font-weight-bold d-block text-nowrap"
                  >
                      {{ data.item.offer_id }}
                  </b-link>
              </b-media>
          </template>

          <!-- Column: conversion -->
          <template #cell(conversion)="data">
              <b-media vertical-align="center">

                  <b-badge class="light-primary"
                      v-if="data.item.conversion === 1">
                      Conversion
                  </b-badge>
                  <b-badge class="light-primary">
                      No Conversion
                  </b-badge>
              </b-media>
          </template>

          <!-- Column: totalCost -->
          <template #cell(totalCost)="data">
              <b-media vertical-align="center">

                      {{ data.item.totalCost }}
              </b-media>
          </template>


          <!-- Column: Report -->
          <template #cell(affiliatePostbackUrl)="data">
              <b-media vertical-align="center">

                      {{ data.item.affiliatePostbackUrl }}

              </b-media>
          </template>


          <!-- Column: Actions -->
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
            <b-dropdown-item :to="{ name: 'apps-report-view', params: { id: data.item.id } }">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">Details</span>
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
import ReportListAddNew from './ReportListAddNew.vue'

export default {
  components: {
    ReportsListFilters,
    ReportListAddNew,

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
  setup() {
      const filterData = ref(null);
    const REPORT = 'app-report'

    // Register module
    if (!store.hasModule(REPORT)) store.registerModule(REPORT, reportStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(REPORT)) store.unregisterModule(REPORT)
    })

    const isAddNewReportSidebarActive = ref(false)

      store.dispatch('app-report/fetchFilterData')
          .then(response => {
              filterData.value = response.data.filterData
          })
          .catch(error => {
              console.log(error)
              filterData.value = undefined

          })



      const conversionOptions = [
          { label: 'Conversion', value: 1 },
          { label: 'No Conversion', value: 0 },
      ]

      const statusOptions = [
          { label: 'Sold', value: 1 },
          { label: 'Pending', value: 2 },
          { label: 'Declined', value: 0 },
      ]


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
      conversionFilter,
      statusFilter,

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



      // Extra Filters
      affIdFilter,
      conversionFilter,
      statusFilter,

    // FILTER DATA
    filterData,
    conversionOptions,
    statusOptions,
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
