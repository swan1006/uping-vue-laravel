<template>

  <div>

    <advertiser-offer-list-add-new
      :is-add-new-advertiser-offer-sidebar-active.sync="isAddNewAdvertiserOfferSidebarActive"
      :role-options="roleOptions"
      :plan-options="planOptions"
      @refetch-data="refetchData"
      :status-options="statusOptions"

    />

    <!-- Filters -->
    <advertiser-offers-list-filters
      :role-filter.sync="roleFilter"
      :plan-filter.sync="planFilter"
      :status-filter.sync="statusFilter"
      :role-options="roleOptions"
      :plan-options="planOptions"
      :status-options="statusOptions"

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
              <b-button
                variant="primary"
                @click="isAddNewAdvertiserOfferSidebarActive = true"
              >
                <span class="text-nowrap">Add Advertiser</span>
              </b-button>
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refAdvertiserOfferListTable"
        class="position-relative"
        :items="fetchAdvertisers"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >

        <!-- Column: Advertiser -->
          <template #cell(company)="data">
              <b-media vertical-align="center">
                  <b-link
                      :to="{ name: 'apps-advertiser-offer-view', params: { id: data.item.id } }"
                      class="font-weight-bold d-block text-nowrap"
                  >
                      <b-badge >
                          <span class="align-text-top text-capitalize">{{ data.item.company.name }}</span>
                      </b-badge>

                  </b-link>
              </b-media>
          </template>

          <template #cell(status)="data">
              <b-badge
                  pill
                  :variant="`light-${resolveAdvertiserOfferStatusVariant(data.item.status)}`"
                  class="text-capitalize"
              >
                  <span v-if="data.item.status === 1">Active</span>
                  <span v-else-if="data.item.status === 2">Pending</span>
                  <span v-else-if="data.item.status === 0">Inactive</span>
              </b-badge>
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
            <b-dropdown-item :to="{ name: 'apps-advertiser-offer-view', params: { id: data.item.id } }">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">Details</span>
            </b-dropdown-item>

            <b-dropdown-item :to="{ name: 'apps-advertiser-offer-edit', params: { id: data.item.id } }">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item>
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50">Delete</span>
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
              :total-rows="totalAdvertisers"
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
import AdvertiserOfferListFilters from './AdvertiserOfferListFilters.vue'
import useAdvertiserOffersList from './useAdvertiserOfferList'
import advertiserOfferStoreModule from '../AdvertiserStoreModule'
import AdvertiserOfferListAddNew from './AdvertiserOfferListAddNew.vue'

export default {
  components: {
    AdvertiserOfferListFilters,
    AdvertiserOfferListAddNew,

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
    // props: {
    //     advertiserData: {
    //         type: Object,
    //         required: true,
    //     }
    // },
  setup() {
    const ADVERTISER_OFFER = 'app-advertiser-offers'

    // Register module
    if (!store.hasModule(ADVERTISER_OFFER)) store.registerModule(ADVERTISER_OFFER, advertiserOfferStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(ADVERTISER_OFFER)) store.unregisterModule(ADVERTISER_OFFER)
    })

    const isAddNewAdvertiserOfferSidebarActive = ref(false)

    const roleOptions = [
      { label: 'Admin', value: 'admin' },
      { label: 'Author', value: 'author' },
      { label: 'Editor', value: 'editor' },
      { label: 'Maintainer', value: 'maintainer' },
      { label: 'Subscriber', value: 'subscriber' },
    ]

    const planOptions = [
      { label: 'Basic', value: 'basic' },
      { label: 'Company', value: 'company' },
      { label: 'Enterprise', value: 'enterprise' },
      { label: 'Team', value: 'team' },
    ]

    const statusOptions = [
      { label: 'Pending', value: 'pending' },
      { label: 'Active', value: 'active' },
      { label: 'Inactive', value: 'inactive' },
    ]




    const {
      fetchAdvertisers,
      tableColumns,
      perPage,
      currentPage,
      totalAdvertisers,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refAdvertiserOfferListTable,
      refetchData,

      // UI
      resolveAdvertiserOfferRoleVariant,
      resolveAdvertiserOfferRoleIcon,
      resolveAdvertiserOfferStatusVariant,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,
    } = useAdvertiserOffersList()

    return {
      // Sidebar
      isAddNewAdvertiserOfferSidebarActive,

      fetchAdvertisers,
      tableColumns,
      perPage,
      currentPage,
      totalAdvertisers,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refAdvertiserOfferListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolveAdvertiserOfferRoleVariant,
      resolveAdvertiserOfferRoleIcon,
      resolveAdvertiserOfferStatusVariant,

      roleOptions,
      planOptions,
      statusOptions,

      // Extra Filters
      roleFilter,
      planFilter,
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
