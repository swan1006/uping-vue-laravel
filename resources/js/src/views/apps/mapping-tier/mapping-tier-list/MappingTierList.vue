<template>

    <div>

        <mapping-tier-list-add-new
            :is-add-new-mapping-tier-sidebar-active.sync="isAddNewMappingTierSidebarActive"
            @refetch-data="refetchData"
            :mapping-data="mappingData"
        />

        <!-- Filters -->
        <mapping-tiers-list-filters
            :lead-type-filter.sync="leadTypeFilter"
            :tier-filter.sync="tierFilter"
            :buyer-filter.sync="buyerFilter"
            :status-filter.sync="statusFilter"

            :filter-tier-data="filterTierData"
            :lead-type-options="leadTypeOptions"
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
                                @click="isAddNewMappingTierSidebarActive = true"
                            >
                                <span class="text-nowrap">Add Tier</span>
                            </b-button>
                        </div>
                    </b-col>
                </b-row>

            </div>

            <b-table
                ref="refMappingTierListTable"
                class="position-relative"
                :items="mappingData.mapping.partner[0].mappings"
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
                        :to="{ name: 'apps-mapping-view', params: { id: data.item.id }}"
                        class="font-weight-bold"
                    >
                        #{{ data.item.id }}
                    </b-link>
                </template>

                <template #cell(leadtype)="data">
                    <b-media vertical-align="center">
                        <template #aside>
                            <b-avatar v-if="data.item.leadtype === '1'"
                                      size="sm"
                                      :src="require('@/assets/images/avatars/flag-uk-icon.png')"
                            />
                            <b-avatar v-else-if="data.item.leadtype === '2'"
                                      size="sm"
                                      :src="require('@/assets/images/avatars/flag-us-icon.png')"
                            />
                        </template>
                        <b-link
                            :to="{ name: 'apps-users-view', params: { id: data.item.id } }"
                            class="font-weight-bold d-block text-nowrap"
                        >
                            {{ data.item.fullName }}
                        </b-link>
                        <small class="text-muted">{{ data.item.username }}</small>
                    </b-media>
                </template>




                <!-- Column: Rotate -->
                <template #cell(rotate)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveMappingTierRotationVariant(data.item.rotate)}`"
                        class="text-capitalize"
                    >
                        <span v-if="data.item.rotate === 1">Active</span>
                        <span v-else-if="data.item.rotate === 0">Inactive</span>
                    </b-badge>

                </template>

                <!-- Column: Status -->
                <template #cell(status)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveMappingTierStatusVariant(data.item.status)}`"
                        class="text-capitalize"
                    >
                        <span v-if="data.item.status === 1">Active</span>
                        <span v-else-if="data.item.status === 2">Pending</span>
                        <span v-else-if="data.item.status === 0">Inactive</span>
                    </b-badge>
                </template>

                <!-- Column: Mode -->
                <template #cell(mode)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveMappingTierModeVariant(data.item.mode)}`"
                        class="text-capitalize"
                    >
                        <span v-if="data.item.mode === 1">Live</span>
                        <span v-else-if="data.item.mode === 2">Test</span>
                        <span v-else-if="data.item.mode === 0">Inactive</span>
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

                        <!-- DELETE -->
                        <b-dropdown-item>
                            <feather-icon icon="TrashIcon"/>
                            <span class="align-middle ml-50" @click="deleteMappingTier(data.item.id)">Delete</span>
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
                            :total-rows="totalMappingTiers"
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
        BFormSelect
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import store from '@/store'
    import {ref, onUnmounted} from '@vue/composition-api'
    import {avatarText} from '@core/utils/filter'
    import MappingTiersListFilters from './MappingTierListFilters.vue'
    import useMappingTiersList from './useMappingTierList'
    import mappingTierStoreModule from '../mappingTierStoreModule'
    import MappingTierListAddNew from './MappingTierListAddNew.vue'

    export default {
        components: {
            MappingTiersListFilters,
            MappingTierListAddNew,

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
            BFormSelect,

            vSelect,
        },
        props: {
            mappingData: {
                type: Object,
                required: true,
            },
        },

        setup() {
            const MAPPING = 'app-mapping-tier'
            const filterTierData = ref(null);
            const mappingData = ref(null);

            // Register module
            if (!store.hasModule(MAPPING)) store.registerModule(MAPPING, mappingTierStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(MAPPING)) store.unregisterModule(MAPPING)
            })

            const isAddNewMappingTierSidebarActive = ref(false)



            function deleteMappingTier(id) {
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
                        store.dispatch('app-mapping-tier/deleteMappingTier', { id: id })
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

            store.dispatch('app-mapping-tier/fetchFilterDataOptions')
                .then(response => {
                    filterTierData.value = response.data.filterTierData
                })
                .catch(error => {
                    filterTierData.value = undefined
                    // if (error.response.status === 404) {
                    //     filterTierData.value = undefined
                    // }
                })

            const leadTypeOptions = [
                {label: 'UK', value: 1},
                {label: 'USA', value: 2},
            ]

            const statusOptions = [
                {label: 'Pending', value: 2},
                {label: 'Active', value: 1},
                {label: 'Inactive', value: 0},
            ]


            const {
                fetchMappingTiers,
                tableColumns,

                perPage,
                totalMappingTiers,
                currentPage,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                dataMeta,
                refMappingTierListTable,
                refetchData,

                // UI
                resolveMappingTierRoleVariant,
                resolveMappingTierRoleIcon,
                resolveMappingTierStatusVariant,
                resolveMappingTierModeVariant,
                resolveMappingTierModelTypeVariant,
                resolveMappingTierRotationVariant,
                // Extra Filters
                leadTypeFilter,
                buyerFilter,
                tierFilter,
                statusFilter,

            } = useMappingTiersList()

            return {
                // Sidebar
                isAddNewMappingTierSidebarActive,
                filterTierData,
                fetchMappingTiers,
                deleteMappingTier,
                tableColumns,
                perPage,
                currentPage,
                totalMappingTiers,
                dataMeta,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                refMappingTierListTable,
                refetchData,

                // Filter
                avatarText,

                // UI
                resolveMappingTierRoleVariant,
                resolveMappingTierRoleIcon,
                resolveMappingTierStatusVariant,
                resolveMappingTierModeVariant,
                resolveMappingTierModelTypeVariant,
                resolveMappingTierRotationVariant,


                // Extra Filters
                leadTypeFilter,
                buyerFilter,
                tierFilter,
                statusFilter,

                statusOptions,
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
