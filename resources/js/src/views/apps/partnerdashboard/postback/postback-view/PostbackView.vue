<template>
    <div>

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="postbackData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching user data
            </h4>
            <div class="alert-body">
                No user found with this user id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-users-list'}"
                >
                    User List
                </b-link>
                for other users.
            </div>
        </b-alert>

        <template v-if="postbackData">
            <!-- First Row -->
            <b-row>
                <b-col
                    cols="12"
                    xl="12"
                    lg="12"
                    md="12"
                >
                    <postback-view-user-info-card :postback-data="postbackData" />
                </b-col>

            </b-row>

            <b-row>
                <b-col
                    cols="12"
                    lg="6"
                >
                </b-col>
                <b-col
                    cols="12"
                    lg="6"
                >
                </b-col>
            </b-row>

        </template>

        <postback-mapping-list :postback-data="postbackData" />

    </div>
</template>

<script>
    import store from '@/store'
    import router from '@/router'
    import { ref, onUnmounted } from '@vue/composition-api'
    import {
        BRow, BCol, BAlert, BLink, BBadge
    } from 'bootstrap-vue'
    import PostbackMappingList from '@/views/apps/postback-mapping/postback-mapping-list/PostbackMappingList.vue'
    import postbackStoreModule from '../PostbackStoreModule'
    import PostbackViewUserInfoCard from './PostbackViewUserInfoCard.vue'
    import PostbackViewUserPlanCard from './PostbackViewUserPlanCard.vue'
    import PostbackViewUserTimelineCard from './PostbackViewUserTimelineCard.vue'
    import PostbackViewUserPermissionsCard from './PostbackViewUserPermissionsCard.vue'

    export default {
        components: {
            BRow,
            BCol,
            BAlert,
            BLink,
            BBadge,

            // Local Components
            PostbackViewUserInfoCard,
            PostbackViewUserPlanCard,
            PostbackViewUserTimelineCard,
            PostbackViewUserPermissionsCard,

            PostbackMappingList,
        },
        setup() {
            const postbackData = ref(null)

            const POSTBACK_STORE_MODULE_NAME = 'app-postback'

            // Register module
            if (!store.hasModule(POSTBACK_STORE_MODULE_NAME)) store.registerModule(POSTBACK_STORE_MODULE_NAME, postbackStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(POSTBACK_STORE_MODULE_NAME)) store.unregisterModule(POSTBACK_STORE_MODULE_NAME)
            })

            store.dispatch('app-postback/fetchPostback', { id: router.currentRoute.params.id })
                .then(response => { postbackData.value = response.data })
                .catch(error => {
                    if (error.response.status === 404) {
                        postbackData.value = undefined
                    }
                })

            return {
                postbackData,
            }
        },
    }
</script>

<style>

</style>
