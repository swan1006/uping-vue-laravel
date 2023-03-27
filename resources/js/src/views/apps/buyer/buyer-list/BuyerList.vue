<template>

    <div>

        <buyer-list-add-new
            :is-add-new-buyer-sidebar-active.sync="isAddNewBuyerSidebarActive"
            :buyer-type-options="buyerTypeOptions"
            @refetch-data="refetchData"
        />

        <!-- Filters -->
        <buyers-list-filters
            :buyer-type-filter.sync="buyerTypeFilter"
            :status-filter.sync="statusFilter"
            :buyer-type-options="buyerTypeOptions"
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
                                @click="isAddNewBuyerSidebarActive = true"
                            >
                                <span class="text-nowrap">Add Buyer</span>
                            </b-button>
                        </div>
                    </b-col>
                </b-row>

            </div>

            <b-table
                ref="refBuyerListTable"
                class="position-relative"
                :items="fetchBuyers"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                empty-text="No matching records found"
                :sort-desc.sync="isSortDirDesc"
                :small="true"
                :striped="true"
            >

                <template #cell(id)="data">
                    <b-link
                        :to="{ name: 'apps-buyers-view', params: { id: data.item.id }}"
                        class="font-weight-bold"
                    >
                        #{{ data.item.id }}
                    </b-link>
                </template>

                <template #cell(buyer)="data">
                    <b-media vertical-align="center">
                        <template #aside>
                            <b-avatar
                                size="32"
                                :src="data.item.avatar"
                                :text="avatarText(data.item.name)"
                                :variant="`light-${resolveBuyerAvatarVariant(data.item.status)}`"
                            />
                        </template>
                        <span class="font-weight-bold d-block text-nowrap">
                              <b-link
                                  :to="{ name: 'apps-buyers-view', params: { id: data.item.id }}"
                                  class="font-weight-bold"
                              >
                            {{ data.item.account_contact1 }}
                              </b-link>
                          </span>
                        <small class="text-muted">{{  data.item.company.email }}</small>
                    </b-media>
                </template>




                <!-- Column: Company -->
                <template #cell(company)="data">
                    <div class="text-nowrap">
                        <b-badge variant="light-primary">
                            <small class="align-text-top text-capitalize">{{ data.item.company.name }}</small>
                        </b-badge>
                    </div>
                </template>

                <template #cell(buyer_type)="data">
                    <small>
                        {{ data.item.buyer_type }}
                    </small>
                </template>

                <!-- Column: Status -->
                <template #cell(status)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveBuyerStatusVariant(data.item.status)}`"
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
                        <!-- VIEW -->
                        <b-dropdown-item :to="{ name: 'apps-buyers-view', params: { id: data.item.id } }">
                            <feather-icon icon="FileTextIcon" />
                            <span class="align-middle ml-50">Details</span>
                        </b-dropdown-item>
                        <!-- VIEW BUYER SETUPS -->
                        <b-dropdown-item :to="{ name: 'apps-buyer-tier-list' }">
                            <feather-icon icon="EyeIcon" />
                            <span class="align-middle ml-50">Tiers</span>
                        </b-dropdown-item>
                        <!-- EDIT -->
                        <b-dropdown-item :to="{ name: 'apps-buyers-edit', params: { id: data.item.id } }">
                            <feather-icon icon="EditIcon" />
                            <span class="align-middle ml-50">Edit</span>
                        </b-dropdown-item>
                        <!-- DELETE -->
                        <b-dropdown-item>
                            <feather-icon icon="TrashIcon" />
                            <span class="align-middle ml-50" @click="deleteBuyer( data.item.id )">Delete</span>
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
                            :total-rows="totalBuyers"
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
    import BuyersListFilters from './BuyerListFilters.vue'
    import useBuyersList from './useBuyerList'
    import buyerStoreModule from '../buyerStoreModule'
    import BuyerListAddNew from './BuyerListAddNew.vue'
    import axios from '@axios'


    export default {
        components: {
            BuyersListFilters,
            BuyerListAddNew,

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
            const BUYERS = 'app-buyers'

            // Register module
            if (!store.hasModule(BUYERS)) store.registerModule(BUYERS, buyerStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(BUYERS)) store.unregisterModule(BUYERS)
            })

            const isAddNewBuyerSidebarActive = ref(false)




            function deleteBuyer(id) {
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
                        store.dispatch('app-buyers/deleteBuyer', { id: id })
                        this.$swal({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Mapping has been deleted.',
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                        })
                        refetchData()
                    } else if (result.dismiss === 'cancel') {
                        this.$swal({
                            title: 'Cancelled',
                            text: 'Mapping not deleted :)',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                        })
                    }
                })
            }


            const {
                fetchBuyers,
                tableColumns,

                perPage,
                totalBuyers,
                currentPage,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                dataMeta,
                refBuyerListTable,
                refetchData,

                // UI
                resolveBuyerRoleVariant,
                resolveBuyerRoleIcon,
                resolveBuyerStatusVariant,
                resolveBuyerAvatarVariant,

                // Extra Filters
                buyerTypeFilter,
                planFilter,
                statusFilter,

                statusOptions,
                buyerTypeOptions,
            } = useBuyersList()

            return {
                // Sidebar
                isAddNewBuyerSidebarActive,

                fetchBuyers,
                deleteBuyer,
                tableColumns,
                perPage,
                currentPage,
                totalBuyers,
                dataMeta,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                refBuyerListTable,
                refetchData,

                // Filter
                avatarText,

                // UI
                resolveBuyerRoleVariant,
                resolveBuyerRoleIcon,
                resolveBuyerStatusVariant,
                resolveBuyerAvatarVariant,

                buyerTypeOptions,
                statusOptions,

                // Extra Filters
                buyerTypeFilter,
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
