<template>

  <div>

    <postback-mapping-list-add-new
      :is-add-new-postback-mapping-sidebar-active.sync="isAddNewPostbackMappingSidebarActive"
      :role-options="roleOptions"
      :plan-options="planOptions"
      @refetch-data="refetchData"
    />

<!--      <postback-mapping-list-edit-new-->
<!--          :is-edit-new-postback-mapping-sidebar-active.sync="isEditNewPostbackMappingSidebarActive"-->
<!--          :role-options="roleOptions"-->
<!--          :plan-options="planOptions"-->
<!--          @refetch-data="refetchData"-->
<!--      />-->

      <postback-mapping-list-details
          :is-details-new-postback-mapping-sidebar-active.sync="isDetailsNewPostbackMappingSidebarActive"
          :role-options="roleOptions"
          :plan-options="planOptions"
          :postback-data="postbackData"
          @refetch-data="refetchData"
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
<!--              <b-button-->
<!--                variant="primary"-->
<!--                @click="isAddNewPostbackMappingSidebarActive = true"-->
<!--              >-->
<!--                <span class="text-nowrap">Add Postback</span>-->
<!--              </b-button>-->
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refPostbackMappingListTable"
        class="position-relative"
        :items="postbackData.postback.postbacks"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
      >

        <!-- Column: POSTBACK NAME -->
          <template #cell(postback_name)="data">
              <b-media vertical-align="center">
                      <b-badge @click="isDetailsNewPostbackMappingSidebarActive = true">
                          <span class="align-text-top text-capitalize">{{ data.item.postback_name }}</span>
                      </b-badge>
              </b-media>
          </template>

          <!-- Column: Global -->
          <template #cell(global)="data">
              <b-badge
                  pill
                  :variant="`light-${resolvePostbackMappingStatusVariant(data.item.global)}`"
                  class="text-capitalize"
              >
                  <span v-if="data.item.global === '1'">Global Postback</span>
                  <span v-else-if="data.item.global === '2'">Offer Postback</span>
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
            <b-dropdown-item  :to="{ name: 'apps-postback-mapping-view', params: { id: data.item.id } }">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">Details</span>
            </b-dropdown-item>

            <b-dropdown-item  :to="{ name: 'apps-postback-mapping-edit', params: { id: data.item.id } }">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">Edit</span>
            </b-dropdown-item>

            <b-dropdown-item>
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50" @click="deletePostbackMapping(data.item.id)">Delete</span>
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
              :total-rows="totalPostbackMappings"
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
import PostbackMappingsListFilters from './PostbackMappingListFilters.vue'
import usePostbackMappingsList from './usePostbackMappingList'
import postbackMappingStoreModule from '../postbackMappingStoreModule'
import PostbackMappingListAddNew from './PostbackMappingListAddNew.vue'
import PostbackMappingListEditNew from './PostbackMappingListEditNew.vue'
import PostbackMappingListDetails from './PostbackMappingListDetails.vue'
import axios from "axios";

export default {
  components: {
    PostbackMappingsListFilters,
    PostbackMappingListAddNew,
    PostbackMappingListEditNew,
    PostbackMappingListDetails,

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
    props: {
        postbackData: {
            type: Object,
            required: true,
        },
    },


    setup() {
    const POSTBACK_MAPPING = 'app-postback'


    // Register module
    if (!store.hasModule(POSTBACK_MAPPING)) store.registerModule(POSTBACK_MAPPING, postbackMappingStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(POSTBACK_MAPPING)) store.unregisterModule(POSTBACK_MAPPING)
    })

    const isAddNewPostbackMappingSidebarActive = ref(false)
    const isEditNewPostbackMappingSidebarActive = ref(false)
    const isDetailsNewPostbackMappingSidebarActive = ref(false)

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
      { label: 'Pending', value: 2 },
      { label: 'Active', value: 1 },
      { label: 'Inactive', value: 0 },
    ]

        function deletePostbackMapping(id) {
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
                    store.dispatch('app-postback/deletePostback', { id: id })
                    this.$swal({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Postback Mapping has been deleted.',
                        customClass: {
                            confirmButton: 'btn btn-success',
                        },
                    })
                    refetchData()
                } else if (result.dismiss === 'cancel') {
                    this.$swal({
                        title: 'Cancelled',
                        text: 'Postback not deleted :)',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-success',
                        },
                    })
                }
            })
        }




        const {
      fetchPostbackMappings,
      tableColumns,
      perPage,
      currentPage,
      totalPostbackMappings,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refPostbackMappingListTable,
      refetchData,

      // UI
      resolvePostbackMappingRoleVariant,
      resolvePostbackMappingRoleIcon,
      resolvePostbackMappingStatusVariant,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,
    } = usePostbackMappingsList()

    return {
      // Sidebar
      isAddNewPostbackMappingSidebarActive,
      isEditNewPostbackMappingSidebarActive,
      isDetailsNewPostbackMappingSidebarActive,

      fetchPostbackMappings,
        deletePostbackMapping,
      tableColumns,
      perPage,
      currentPage,
      totalPostbackMappings,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refPostbackMappingListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolvePostbackMappingRoleVariant,
      resolvePostbackMappingRoleIcon,
      resolvePostbackMappingStatusVariant,

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
