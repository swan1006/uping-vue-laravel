<template>
  <component :is="postbackMappingData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="postbackMappingData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching postback data
      </h4>
      <div class="alert-body">
        No postback found with this postback id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-postback-mapping-list'}"
        >
          Postback List
        </b-link>
        for other postbacks.
      </div>
    </b-alert>

    <b-tabs
      v-if="postbackMappingData"
      pills
    >

      <!-- Tab: Account -->
      <b-tab active>
        <template #title>
          <feather-icon
            icon="UserIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Postback </span>
        </template>
        <postback-mapping-edit-tab-account
            :postback-mapping-data="postbackMappingData"
            class="mt-2 pt-75"
        />
      </b-tab>



    </b-tabs>
  </component>
</template>

<script>
import {
  BTab, BTabs, BCard, BAlert, BLink,
} from 'bootstrap-vue'
import { ref, onUnmounted } from '@vue/composition-api'
import router from '@/router'
import store from '@/store'
import postbackMappingStoreModule from '../postbackMappingStoreModule'
import PostbackMappingEditTabAccount from './PostbackMappingEditTabAccount.vue'
import PostbackMappingEditTabInformation from './PostbackMappingEditTabInformation.vue'
import PostbackMappingEditTabSocial from './PostbackMappingEditTabSocial.vue'

export default {
  components: {
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    PostbackMappingEditTabAccount,
    PostbackMappingEditTabInformation,
    PostbackMappingEditTabSocial,
  },
  setup() {

      const postbackMappingData = ref(null)

    const POSTBACK_MAPPING = 'app-postback-mapping'

    // Register module
    if (!store.hasModule(POSTBACK_MAPPING)) store.registerModule(POSTBACK_MAPPING, postbackMappingStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(POSTBACK_MAPPING)) store.unregisterModule(POSTBACK_MAPPING)
    })

    store.dispatch('app-postback-mapping/fetchPostbackMapping', { id: router.currentRoute.params.id })
      .then(response => { postbackMappingData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          postbackMappingData.value = undefined
        }
      })

    return {
      postbackMappingData,
    }
  },
}
</script>

<style>

</style>
