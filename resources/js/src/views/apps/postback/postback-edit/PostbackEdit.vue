<template>
  <component :is="postbackData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="postbackData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching buyer data
      </h4>
      <div class="alert-body">
        No buyer found with this buyer id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-postbacks-list'}"
        >
          Postback List
        </b-link>
        for other postbacks.
      </div>
    </b-alert>

    <b-tabs
      v-if="postbackData"
      pills
    >

      <!-- Tab: Account -->
      <b-tab active>
        <template #title>
          <feather-icon
            icon="PostbackIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Account</span>
        </template>
        <postback-edit-tab-account
          :postback-data="postbackData"
          :filter-data="filterData"
          class="mt-2 pt-75"
        />
      </b-tab>


<!--      &lt;!&ndash; Tab: Information &ndash;&gt;-->
<!--      <b-tab>-->
<!--        <template #title>-->
<!--          <feather-icon-->
<!--            icon="InfoIcon"-->
<!--            size="16"-->
<!--            class="mr-0 mr-sm-50"-->
<!--          />-->
<!--          <span class="d-none d-sm-inline">Information</span>-->
<!--        </template>-->
<!--        <postback-edit-tab-information class="mt-2 pt-75"    :postback-data="postbackData" />-->
<!--      </b-tab>-->

<!--      &lt;!&ndash; Tab: Social &ndash;&gt;-->
<!--      <b-tab>-->
<!--        <template #title>-->
<!--          <feather-icon-->
<!--            icon="Share2Icon"-->
<!--            size="16"-->
<!--            class="mr-0 mr-sm-50"-->
<!--          />-->
<!--          <span class="d-none d-sm-inline">Social</span>-->
<!--        </template>-->
<!--        <postback-edit-tab-social class="mt-2 pt-75"    :postback-data="postbackData" />-->
      </b-tab>

        <!-- Tab: Postback Mapping -->
<!--        <b-tab active>-->
<!--            <template #title>-->
<!--                <feather-icon-->
<!--                    icon="InfoIcon"-->
<!--                    size="16"-->
<!--                    class="mr-0 mr-sm-50"-->
<!--                />-->
<!--                <span class="d-none d-sm-inline">Mapping</span>-->
<!--            </template>-->
<!--            <postback-mapping-tab-account-->
<!--                :postback-data="postbackData"-->
<!--                class="mt-2 pt-75"-->
<!--            />-->
<!--        </b-tab>-->
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
import postbackStoreModule from '../PostbackStoreModule'
import PostbackEditTabAccount from './PostbackEditTabAccount.vue'
import PostbackEditTabInformation from './PostbackEditTabInformation.vue'
import PostbackEditTabSocial from './PostbackEditTabSocial.vue'

export default {
  components: {
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    PostbackEditTabAccount,
    PostbackEditTabInformation,
    PostbackEditTabSocial,
  },
  setup() {
    const postbackData = ref(null)

    const POSTBACK = 'app-postback'

    // Register module
    if (!store.hasModule(POSTBACK)) store.registerModule(POSTBACK, postbackStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(POSTBACK)) store.unregisterModule(POSTBACK)
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
