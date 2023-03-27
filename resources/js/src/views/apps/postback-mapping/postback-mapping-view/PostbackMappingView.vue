<template>
    <div>

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="postbackData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching mapping data
            </h4>
            <div class="alert-body">
                No mapping found with this mapping id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-postback-mapping-list'}"
                >
                    User List
                </b-link>
                for other mappings.
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
                    <postback-mapping-view-user-info-card :postback-data="postbackData" />
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

    </div>
</template>

<script>
    import store from '@/store'
    import router from '@/router'
    import { ref, onUnmounted } from '@vue/composition-api'
    import {
        BRow, BCol, BAlert, BLink, BBadge
    } from 'bootstrap-vue'
    import PostbackMappingList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
    import postbackMappingStoreModule from '../postbackMappingStoreModule'
    import PostbackMappingViewUserInfoCard from './PostbackMappingViewUserInfoCard.vue'
    import PostbackMappingViewUserPlanCard from './PostbackMappingViewUserPlanCard.vue'
    import PostbackMappingViewUserTimelineCard from './PostbackMappingViewUserTimelineCard.vue'
    import PostbackMappingViewUserPermissionsCard from './PostbackMappingViewUserPermissionsCard.vue'

    export default {
        components: {
            BRow,
            BCol,
            BAlert,
            BLink,
            BBadge,

            // Local Components
            PostbackMappingViewUserInfoCard,
            PostbackMappingViewUserPlanCard,
            PostbackMappingViewUserTimelineCard,
            PostbackMappingViewUserPermissionsCard,

            PostbackMappingList,
        },
        setup() {


            const postbackData = ref(null)

            const POSTBACK_MAPPING = 'app-postback-mapping'

            // Register module
            if (!store.hasModule(POSTBACK_MAPPING)) store.registerModule(POSTBACK_MAPPING, postbackMappingStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(POSTBACK_MAPPING)) store.unregisterModule(POSTBACK_MAPPING)
            })

            store.dispatch('app-postback-mapping/fetchPostbackMapping', { id: router.currentRoute.params.id })
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
