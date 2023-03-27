<template>

    <div>

        <user-list-add-new
            :is-add-new-user-sidebar-active.sync="isAddNewUserSidebarActive"
            :role-options="roleOptions"
            @refetch-data="refetchData"
        />

        <!-- Filters -->
        <users-list-filters
            :role-filter.sync="roleFilter"
            :status-filter.sync="statusFilter"
            :role-options="roleOptions"
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
                                @click="isAddNewUserSidebarActive = true"
                            >
                                <span class="text-nowrap">Add User</span>
                            </b-button>
                        </div>
                    </b-col>
                </b-row>

            </div>

            <b-table
                ref="refUserListTable"
                class="position-relative"
                :items="fetchUsers"
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
                        :to="{ name: 'apps-users-view', params: { id: data.item.id }}"
                        class="font-weight-bold"
                    >
                        #{{ data.item.id }}
                    </b-link>
                </template>

                <template #cell(user)="data">
                    <b-media vertical-align="center">
                        <template #aside>

                            <b-avatar
                                size="32"
                                :src="data.item.avatar"
                                :text="avatarText(data.item.name)"
                                :variant="`light-${resolveUserAvatarVariant(data.item.status)}`"
                            />

                        </template>
                        <b-link
                            :to="{ name: 'apps-users-view', params: { id: data.item.id }}"
                            class="font-weight-bold"
                        >
                        <small class="font-weight-bold d-block text-nowrap">
                            {{ data.item.username }}
                          </small>
                                  <small class="text-muted">{{  data.item.company.email  }}</small>
                        </b-link>


                    </b-media>
                </template>



                <!-- Column: Company -->
                <template #cell(company)="data">
                    <div class="text-nowrap">
                        <b-badge variant="light-primary">
                            <b-link
                                :to="{ name: 'apps-users-view', params: { id: data.item.id }}"
                                class="font-weight-bold"
                            >
                            <small class="align-text-top text-capitalize">{{ data.item.company.name}}</small>
                            </b-link>

                        </b-badge>
                    </div>
                </template>

                <!-- Column: Status -->
                <template #cell(status)="data">
                    <b-badge
                        pill
                        :variant="`light-${resolveUserStatusVariant(data.item.status)}`"
                        class="text-capitalize"
                    >
                        <small v-if="data.item.status === 1">Active</small>
                        <small v-else-if="data.item.status === 2">Pending</small>
                        <small v-else-if="data.item.status === 0">Inactive</small>
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
                        <b-dropdown-item :to="{ name: 'apps-users-view', params: { id: data.item.id } }">
                            <feather-icon icon="FileTextIcon"/>
                            <small class="align-middle ml-50">Details</small>
                        </b-dropdown-item>
                        <!-- EDIT -->
                        <b-dropdown-item :to="{ name: 'apps-users-edit', params: { id: data.item.id } }">
                            <feather-icon icon="EditIcon"/>
                            <small class="align-middle ml-50">Edit</small>
                        </b-dropdown-item>
                        <!-- DELETE -->
                        <b-dropdown-item>
                            <feather-icon icon="TrashIcon"/>
                            <small class="align-middle ml-50" @click="deleteUser(data.item.id)">Delete</small>
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
                        <small class="text-muted">Showing {{ dataMeta.from }} to {{ dataMeta.to }} of {{ dataMeta.of }} entries</small>
                    </b-col>
                    <!-- Pagination -->
                    <b-col
                        cols="12"
                        sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-end"
                    >

                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalUsers"
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
    import UsersListFilters from './UserListFilters.vue'
    import useUsersList from './useUserList'
    import userStoreModule from '../UserStoreModule'
    import UserListAddNew from './UserListAddNew.vue'

    export default {
        components: {
            UsersListFilters,
            UserListAddNew,

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
            const USERS = 'app-users'

            // Register module
            if (!store.hasModule(USERS)) store.registerModule(USERS, userStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(USERS)) store.unregisterModule(USERS)
            })

            const isAddNewUserSidebarActive = ref(false)

            const roleOptions = [
                {label: 'Admin', value: 1},
                {label: 'Partner', value: 0},
                {label: 'Staff', value: 2},
            ]
            const statusOptions = [
                {label: 'Pending', value: 2},
                {label: 'Active', value: 1},
                {label: 'Inactive', value: 0},
            ]

            function deleteUser(id) {
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
                        store.dispatch('app-users/deleteUser', { id: id })
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
                fetchUsers,

                tableColumns,
                perPage,
                totalUsers,
                currentPage,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                dataMeta,
                refUserListTable,
                refetchData,

                // UI
                resolveUserRoleVariant,
                resolveUserRoleIcon,
                resolveUserStatusVariant,
                resolveUserAvatarVariant,

                // Extra Filters
                roleFilter,
                planFilter,
                statusFilter,
            } = useUsersList()


            return {
                // Sidebar
                isAddNewUserSidebarActive,

                fetchUsers,
                deleteUser,
                resolveUserAvatarVariant,

                tableColumns,
                perPage,
                currentPage,
                totalUsers,
                dataMeta,
                perPageOptions,
                searchQuery,
                sortBy,
                isSortDirDesc,
                refUserListTable,
                refetchData,

                // Filter
                avatarText,

                // UI
                resolveUserRoleVariant,
                resolveUserRoleIcon,
                resolveUserStatusVariant,

                roleOptions,
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
