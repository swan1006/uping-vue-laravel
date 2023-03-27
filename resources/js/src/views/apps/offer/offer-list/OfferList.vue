<template>

  <div>

    <offer-list-add-new
      :is-add-new-offer-sidebar-active.sync="isAddNewOfferSidebarActive"
      :role-options="roleOptions"
      :plan-options="planOptions"
      @refetch-data="refetchData"
    />

    <!-- Filters -->
    <offers-list-filters
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
                @click="isAddNewOfferSidebarActive = true"
              >
                <span class="text-nowrap">Add Offer</span>
              </b-button>
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refOfferListTable"
        class="position-relative"
        :items="fetchOffers"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >

        <!-- Column: Offer -->
        <template #cell(name)="data">
          <b-media vertical-align="center">
            <template #aside>
              <b-avatar
                size="32"
                :src="data.item.logo"
                :text="avatarText(data.item.name)"
                :variant="`light-${resolveOfferRoleVariant(data.item.role)}`"
                :to="{ name: 'apps-ecommerce-product-details', params: { id: data.item.id } }"
              />
            </template>
            <b-link
              :to="{ name: 'apps-offer-view', params: { id: data.item.id } }"
              class="font-weight-bold d-block text-nowrap"
            >
              {{ data.item.name }}
            </b-link>
<!--            <small class="text-muted">{{ data.item.offername }}</small>-->
          </b-media>
        </template>


          <!-- Column: Status -->
          <template #cell(status)="data">
              <b-badge
                  pill
                  :variant="`light-${resolveOfferStatusVariant(data.item.status)}`"
                  class="text-capitalize"
              >
                  <span v-if="data.item.status === '1'">Active</span>
                  <span v-else-if="data.item.status === '2'">Pending</span>
                  <span v-else-if="data.item.status === '0'">Inactive</span>
              </b-badge>
          </template>

          <!-- Column: GEOS -->
          <template #cell(geos)="data">
              <b-badge
                  pill
                  class="text-capitalize"
              >
                  <span v-if="data.item.status === '1'">UK</span>
                  <span v-else-if="data.item.status === '2'">USA</span>
                  <span v-else-if="data.item.status === '0'">Other</span>
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
            <b-dropdown-item :to="{ name: 'apps-offer-view', params: { id: data.item.id } }">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">Details</span>
            </b-dropdown-item>

            <b-dropdown-item :to="{ name: 'apps-offer-edit', params: { id: data.item.id } }">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item>
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50" @click="deleteOffer(data.item.id)">Delete</span>
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
              :total-rows="totalOffers"
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
import OffersListFilters from './OfferListFilters.vue'
import useOffersList from './useOfferList'
import offerStoreModule from '../OfferStoreModule'
import OfferListAddNew from './OfferListAddNew.vue'

export default {
  components: {
    OffersListFilters,
    OfferListAddNew,

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
    const OFFER = 'app-offer'

    // Register module
    if (!store.hasModule(OFFER)) store.registerModule(OFFER, offerStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(OFFER)) store.unregisterModule(OFFER)
    })

    const isAddNewOfferSidebarActive = ref(false)

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
      function deleteOffer(id) {
          this.$swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              customClass: {
                  confirmButton: 'btn btn-primary',
                  cancelButton: 'btn btn-outline-danger ml-1',
              },
              buttonsStyling: false,
          }).then(result => {
              if (result.value) {
                  store.dispatch('app-offer/deleteOffer', { id: id })
                  this.$swal({
                      icon: 'success',
                      title: 'Deleted!',
                      text: 'Offer has been deleted.',
                      customClass: {
                          confirmButton: 'btn btn-success',
                      },
                  })
                  refetchData()
              } else if (result.dismiss === 'cancel') {
                  this.$swal({
                      title: 'Cancelled',
                      text: 'Offer not deleted :)',
                      icon: 'error',
                      customClass: {
                          confirmButton: 'btn btn-success',
                      },
                  })
              }
          })
      }



      const {
      fetchOffers,
      tableColumns,
      perPage,
      currentPage,
      totalOffers,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refOfferListTable,
      refetchData,

      // UI
      resolveOfferRoleVariant,
      resolveOfferRoleIcon,
      resolveOfferStatusVariant,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,
    } = useOffersList()

    return {
      // Sidebar
      isAddNewOfferSidebarActive,
      deleteOffer,
      fetchOffers,
      tableColumns,
      perPage,
      currentPage,
      totalOffers,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refOfferListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolveOfferRoleVariant,
      resolveOfferRoleIcon,
      resolveOfferStatusVariant,

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
