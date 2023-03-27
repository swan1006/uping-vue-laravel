<template>

    <div>


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
                                :to="{ name: 'apps-filter-add' }"

                            >
                                <span class="text-nowrap">Add Filter</span>
                            </b-button>
                        </div>
                    </b-col>
                </b-row>

            </div>


            <b-table
                ref="refFilterListTable"
                class="position-relative"
                responsive
                :items="buyerFilterData.buyerFilter.buyer_filters"
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                empty-text="No matching records found"
                :sort-desc.sync="isSortDirDesc"
            >



                <!-- Column: Company -->
                <template #cell(filter_type)="data">
                    <b-link
                        :to="{ name: 'apps-filter-view', params: { id: data.item.id } }"
                        class="font-weight-bold d-block text-nowrap"
                    >
                        <b-badge
                        pill
                        class="text-capitalize"
                    >
                        <span >{{ data.item.filter_type }}</span>
                    </b-badge>
                    </b-link>
                </template>

                <!-- Column: Company -->
                <template #cell(conditions)="data">
                    <b-link
                        :to="{ name: 'apps-filter-view', params: { id: data.item.id } }"
                        class="font-weight-bold d-block text-nowrap"
                        >
                        <b-badge
                            pill
                            class="text-capitalize"
                        >
                            View
                        </b-badge>
                    </b-link>
                </template>

                <!-- Column: Status -->
                <template #cell(status)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveFilterStatusVariant(data.item.status)}`"
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
                        <b-dropdown-item :to="{ name: 'apps-filter-view', params: { id: data.item.id } }">
                            <feather-icon icon="FileTextIcon" />
                            <span class="align-middle ml-50">Details</span>
                        </b-dropdown-item>
                        <!--EDIT-->
                        <b-dropdown-item :to="{ name: 'apps-filter-edit', params: { id: data.item.id } }">
                            <feather-icon icon="EditIcon" />
                            <span class="align-middle ml-50">Edit</span>
                        </b-dropdown-item>
                        <!-- DELETE -->
                        <b-dropdown-item>
                            <feather-icon icon="TrashIcon" />
                            <span class="align-middle ml-50" @click="deleteFilter(data.item.id)">Delete</span>
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
                            :total-rows="totalFilters"
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
        BModal,
        BCardText,
        VBModal,
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import store from '@/store'
    import { ref, onUnmounted } from '@vue/composition-api'
    import { avatarText } from '@core/utils/filter'
    import FiltersListFilters from './FilterListFilters.vue'
    import useFiltersList from './useFilterList'
    import filterStoreModule from '../filterStoreModule'
    import FilterListAddNew from './FilterListAddNew.vue'
    import axios from '@axios'

    export default {
        components: {
            FiltersListFilters,
            FilterListAddNew,

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
            BModal,
            BCardText,
            vSelect,
            VBModal,
        },
        props: {
            buyerFilterData: {
                type: Object,
                required: true,
            },
        },

        setup() {
            const FILTERS = 'app-filters'

            // Register module
            if (!store.hasModule(FILTERS)) store.registerModule(FILTERS, filterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(FILTERS)) store.unregisterModule(FILTERS)
            })

            const isAddNewFilterSidebarActive = ref(false)
            const roleOptions = [
                { label: 'Admin', value: '1' },
                { label: 'Partner', value: '0' },
                { label: 'Buyer', value: '2' },
                { label: 'Staff', value: '3' },
            ]
            const statusOptions = [
                { label: 'Pending', value: '2' },
                { label: 'Active', value: '1' },
                { label: 'Inactive', value: '0' },
            ]

            function deleteFilter(id) {
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
                        store.dispatch('app-filters/deleteFilter', { id: id })
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
                fetchFilters,
                tableColumns,
                perPage,
                totalFilters,
                currentPage,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                dataMeta,
                refFilterListTable,
                refetchData,

                // UI
                resolveFilterRoleVariant,
                resolveFilterRoleIcon,
                resolveFilterStatusVariant,

                // Extra Filters
                roleFilter,
                planFilter,
                statusFilter,
                goBack,
            } = useFiltersList()

            return {
                // Sidebar
                isAddNewFilterSidebarActive,

                fetchFilters,
                deleteFilter,
                tableColumns,
                perPage,
                currentPage,
                totalFilters,
                dataMeta,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                refFilterListTable,
                refetchData,


                // UI
                resolveFilterRoleVariant,
                resolveFilterRoleIcon,
                resolveFilterStatusVariant,

                roleOptions,
                statusOptions,

                // Extra Filters
                roleFilter,
                planFilter,
                statusFilter,
                goBack,

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
