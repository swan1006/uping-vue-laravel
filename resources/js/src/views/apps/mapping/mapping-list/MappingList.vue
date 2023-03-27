<template>

  <div>

    <!-- Filters -->
    <mappings-list-filters
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
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refMappingListTable"
        class="position-relative"
        :items="fetchMappings"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >
          <template #cell(id)="data">
              <b-link
                  :to="{ name: 'apps-users-view', params: { id: data.item.id }}"
                  class="font-weight-bold"
              >
                  #{{ data.item.id }}
              </b-link>
          </template>




          <!-- Column: Mapping -->
          <template #cell(tier)="data">
              <b-media vertical-align="center">
                  <b-link
                      :to="{ name: 'apps-mapping-view', params: { id: data.item.id } }"
                      class="font-weight-bold d-block text-nowrap"
                  >
                      <b-badge >
                          <span class="align-text-top text-capitalize">{{ data.item.buyername }}</span>

                      </b-badge>

                  </b-link>
              </b-media>
          </template>

        <!-- Column: Role -->
        <template #cell(vendor_id)="data">
          <div class="text-nowrap">
              <b-link
                  :to="{ name: 'apps-mapping-view', params: { slug: data.item.vendor_id } }"
                  class="font-weight-bold d-block text-nowrap"
              >

            <feather-icon
              :icon="resolveMappingRoleIcon(data.item.vid)"
              size="18"
              class="mr-50"
              :class="`text-${resolveMappingRoleVariant(data.item.vid)}`"
            />
              <b-badge
                  class="text-capitalize"
              >
            <span class="align-text-top text-capitalize">{{ data.item.vendor_id }}</span>
              </b-badge>
              </b-link>

          </div>
        </template>

          <!-- Column: Role -->
          <template #cell(tiers)="data">
              <div class="text-nowrap">
                  <b-link
                      :to="{ name: 'apps-mapping-view', params: { slug: data.item.vendor_id } }"
                      class="font-weight-bold d-block text-nowrap"
                  >
                          <span class="align-text-top text-capitalize">{{ data.item.mappings.length }} Active Tiers</span>
                  </b-link>

              </div>
          </template>

          <!-- Column: Status -->
          <template #cell(status)="data">
              <b-badge
                  pill
                  :variant="`light-${resolveMappingStatusVariant(data.item.status)}`"
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
            <b-dropdown-item    :to="{ name: 'apps-mapping-view', params: { slug: data.item.vendor_id } }">
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
              :total-rows="totalMappings"
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
import MappingsListFilters from './MappingListFilters.vue'
import useMappingsList from './useMappingList'
import mappingStoreModule from '../MappingStoreModule'
import MappingListAddNew from './MappingListAddNew.vue'

export default {
  components: {
    MappingsListFilters,
    MappingListAddNew,

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
    const MAPPING = 'app-mapping'

    // Register module
    if (!store.hasModule(MAPPING)) store.registerModule(MAPPING, mappingStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(MAPPING)) store.unregisterModule(MAPPING)
    })

    // const isAddNewMappingSidebarActive = ref(false)

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


      function deleteMapping(id) {
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
                  // axios.delete(`http://127.0.0.1:8000/api/tiers/${id}`)
                  store.dispatch('app-mapping/deleteMapping', { id: id })
                  this.$swal({
                      icon: 'success',
                      title: 'Deleted!',
                      text: 'Your file has been deleted.',
                      customClass: {
                          confirmButton: 'btn btn-success',
                      },
                  })
              } else if (result.dismiss === 'cancel') {
                  this.$swal({
                      title: 'Cancelled',
                      text: 'Your imaginary file is safe :)',
                      icon: 'error',
                      customClass: {
                          confirmButton: 'btn btn-success',
                      },
                  })
              }
          })
      }


      const {
      fetchMappings,
      tableColumns,
      perPage,
      currentPage,
      totalMappings,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refMappingListTable,
      refetchData,

      // UI
      resolveMappingRoleVariant,
      resolveMappingRoleIcon,
      resolveMappingStatusVariant,
          resolveMappingStatusVariantAndIcon,
          resolveMappingAvatarVariant,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,

        leadTypeOptions,

    } = useMappingsList()

    return {
      // Sidebar
      // isAddNewMappingSidebarActive,
      deleteMapping,
      fetchMappings,
      tableColumns,
      perPage,
      currentPage,
      totalMappings,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refMappingListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolveMappingRoleVariant,
      resolveMappingRoleIcon,
      resolveMappingStatusVariant,
        resolveMappingStatusVariantAndIcon,
        resolveMappingAvatarVariant,

      roleOptions,
      planOptions,
      statusOptions,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,

        leadTypeOptions,
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
