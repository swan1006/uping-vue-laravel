<template>
  <component :is="mappingData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="mappingData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching mapping data
      </h4>
      <div class="alert-body">
        No mapping found with this mapping id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-mapping-list'}"
        >
          Mapping List
        </b-link>
        for other partners.
      </div>
    </b-alert>

    <b-tabs
      v-if="mappingData"
      pills
    >

      <!-- Tab: Account -->
      <b-tab active>
        <template #title>
          <feather-icon
            icon="BuyerIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Edit</span>
        </template>
        <mapping-edit-tab-account
          :mapping-data="mappingData"
          class="mt-2 pt-75"
        />
      </b-tab>


      <!-- Tab: Information -->
<!--      <b-tab>-->
<!--        <template #title>-->
<!--          <feather-icon-->
<!--            icon="InfoIcon"-->
<!--            size="16"-->
<!--            class="mr-0 mr-sm-50"-->
<!--          />-->
<!--          <span class="d-none d-sm-inline">Active</span>-->
<!--        </template>-->
<!--        <mapping-edit-tab-information class="mt-2 pt-75" />-->
<!--      </b-tab>-->


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
import mappingStoreModule from '../MappingStoreModule'
import MappingEditTabAccount from './MappingEditTabAccount.vue'
import MappingEditTabInformation from './MappingEditTabInformation.vue'
import MappingEditTabSocial from './MappingEditTabSocial.vue'
import MappingTabAccount from './MappingTabAccount.vue'

export default {
  components: {
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    MappingEditTabAccount,
    MappingEditTabInformation,
    MappingEditTabSocial,
  },
  setup() {
    const mappingData = ref(null)

    const MAPPING = 'app-mapping'

    // Register module
    if (!store.hasModule(MAPPING)) store.registerModule(MAPPING, mappingStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(MAPPING)) store.unregisterModule(MAPPING)
    })

    store.dispatch('app-mapping/fetchMapping', { id: router.currentRoute.params.id })
      .then(response => { mappingData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          mappingData.value = undefined
        }
      })

    return {
      mappingData,
    }
  },
}
</script>

<style>

</style>
