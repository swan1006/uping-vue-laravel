<template>

    <div>

        <buyer-tier-list-add-new
            :is-add-new-buyer-tier-sidebar-active.sync="isAddNewBuyerTierSidebarActive"
            :lead-type-options="leadTypeOptions"
            @refetch-data="refetchData"
        />

        <!-- Filters -->
        <buyer-tiers-list-filters
            :lead-type-filter.sync="leadTypeFilter"
            :model-type-filter.sync="modelTypeFilter"
            :status-filter.sync="statusFilter"
            :lead-type-options="leadTypeOptions"
            :model-type-options="modelTypeOptions"
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
                                @click="isAddNewBuyerTierSidebarActive = true"
                            >
                                <span class="text-nowrap">Add Tier</span>
                            </b-button>
                        </div>
                    </b-col>
                </b-row>

            </div>

            <b-table
                ref="refBuyerTierListTable"
                class="position-relative"
                :items="fetchBuyerTiers"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                empty-text="No matching records found"
                :sort-desc.sync="isSortDirDesc"
            >


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
                        </b-link>
                    </b-media>
                </template>


                <!-- Column: Company -->
                <template #cell(buyername)="data">
                    <div class="text-nowrap">
                        <b-link
                            :to="{ name: 'apps-buyer-tier-view', params: { id: data.item.id } }"
                            class="font-weight-bold d-block text-nowrap"
                        >
                            <b-badge>
                                <span>{{ data.item.buyername }}</span>
                            </b-badge>
                        </b-link>

                    </div>
                </template>

                <!-- Column: Mode -->
                <template #cell(model_type)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveBuyerTierModelTypeVariant(data.item.model_type)}`"
                        class="text-capitalize"
                    >
                        {{data.item.model_type}}
<!--                        <span v-else-if="data.item.model_type == '2'">CPL</span>-->
<!--                        <span v-else-if="data.item.model_type == '3'">CPF</span>-->
<!--                        <span v-else-if="data.item.model_type == '4'">Hybrid</span>-->
                    </b-badge>
                </template>

                <!-- Column: Rotate -->
                <template #cell(rotate)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveBuyerTierRotationVariant(data.item.rotate)}`"
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
                        :variant="`light-${resolveBuyerTierStatusVariant(data.item.status)}`"
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
                        :variant="`light-${resolveBuyerTierModeVariant(data.item.mode)}`"
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
                        <!-- VIEW -->
                        <b-dropdown-item :to="{ name: 'apps-buyer-tier-view', params: { id: data.item.id } }">
                            <feather-icon icon="FileTextIcon"/>
                            <span class="align-middle ml-50">Details</span>
                        </b-dropdown-item>
                        <!-- DELETE -->
                        <b-dropdown-item>
                            <feather-icon icon="TrashIcon"/>
                            <span class="align-middle ml-50" @click="deleteBuyerTier(data.item.id)">Delete</span>
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
                            :total-rows="totalBuyerTiers"
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
    import {ref, onUnmounted} from '@vue/composition-api'
    import {avatarText} from '@core/utils/filter'
    import BuyerTiersListFilters from './BuyerTierListFilters.vue'
    import useBuyerTiersList from './useBuyerTierList'
    import buyerTierStoreModule from '../buyerTierStoreModule'
    import BuyerTierListAddNew from './BuyerTierListAddNew.vue'
    import axios from '@axios'

    export default {
        components: {
            BuyerTiersListFilters,
            BuyerTierListAddNew,

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
            const BUYERTIER = 'app-buyer-tier'
            const isAddNewBuyerTierSidebarActive = ref(false)
            const statusOptions = [
                {label: 'Pending', value: '2'},
                {label: 'Active', value: '1'},
                {label: 'Inactive', value: '0'},
            ]
            const modeOptions = [
                {label: 'Live', value: 1},
                {label: 'Test', value: 2},
                {label: 'Inactive', value: 0},
            ]
            const leadTypeOptions = [
                {label: 'UK', value: 1},
                {label: 'USA', value: 2},
            ]
            const modelTypeOptions = [
                {label: 'CPA', value: 1},
                {label: 'CPL', value: 2},
                {label: 'CPF', value: 3},
                {label: 'Hybrid', value: 4},
            ]
            const ukFlag = require('@/assets/images/avatars/flag-us-icon.png')
            const usFlag = require('@/assets/images/avatars/flag-us-icon.png')
            // Register module
            if (!store.hasModule(BUYERTIER)) store.registerModule(BUYERTIER, buyerTierStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(BUYERTIER)) store.unregisterModule(BUYERTIER)
            })



            function deleteBuyerTier(id) {
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
                        store.dispatch('app-buyer-tier/deleteBuyerTier', { id: id })
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
                fetchBuyerTiers,
                tableColumns,

                perPage,
                totalBuyerTiers,
                currentPage,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                dataMeta,
                refBuyerTierListTable,
                refetchData,

                // UI
                resolveBuyerTierRoleVariant,
                resolveBuyerTierRoleIcon,
                resolveBuyerTierStatusVariant,
                resolveBuyerTierModeVariant,
                resolveBuyerTierModelTypeVariant,
                resolveBuyerTierRotationVariant,
                // Extra Filters
                leadTypeFilter,
                modelTypeFilter,
                statusFilter,

            } = useBuyerTiersList()

            return {
                // Sidebar
                isAddNewBuyerTierSidebarActive,

                fetchBuyerTiers,
                deleteBuyerTier,
                tableColumns,
                perPage,
                currentPage,
                totalBuyerTiers,
                dataMeta,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                refBuyerTierListTable,
                refetchData,

                // Filter
                avatarText,

                // UI
                resolveBuyerTierRoleVariant,
                resolveBuyerTierRoleIcon,
                resolveBuyerTierStatusVariant,
                resolveBuyerTierModeVariant,
                resolveBuyerTierModelTypeVariant,
                resolveBuyerTierRotationVariant,

                modeOptions,

                statusOptions,
                leadTypeOptions,
                modelTypeOptions,

                // Extra Filters
                leadTypeFilter,
                modelTypeFilter,
                statusFilter,
                ukFlag,
                usFlag
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
