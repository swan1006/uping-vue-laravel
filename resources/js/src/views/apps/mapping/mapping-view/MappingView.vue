<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="mappingData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching mapping tier data
      </h4>
      <div class="alert-body">
        No buyer found with this mapping tier id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-mapping-list'}"
        >
          Mapping Tier List
        </b-link>
        for other buyers.
      </div>
    </b-alert>

    <template v-if="mappingData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="12"
          lg="12"
          md="12"
        >
          <mapping-view-user-info-card
              :mapping-data="mappingData" />
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

      <mapping-tier-list
          :mapping-data="mappingData"
          :status-options="statusOptions"
          :lead-type-options="leadTypeOptions"
      />
    </template>

  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { ref, onUnmounted } from '@vue/composition-api'
import {
  BRow, BCol, BAlert, BLink,
} from 'bootstrap-vue'
import mappingStoreModule from '../MappingStoreModule'
import MappingViewUserInfoCard from './MappingViewUserInfoCard.vue'
import MappingViewUserPlanCard from './MappingViewUserPlanCard.vue'
import MappingViewUserTimelineCard from './MappingViewUserTimelineCard.vue'
import MappingViewUserPermissionsCard from './MappingViewUserPermissionsCard.vue'
import MappingTierList from "../../mapping-tier/mapping-tier-list/MappingTierList";

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    MappingViewUserInfoCard,
    MappingViewUserPlanCard,
    MappingViewUserTimelineCard,
    MappingViewUserPermissionsCard,

      MappingTierList,

  },
    data() {
        mappingData
    },
    beforeCreate() {
        const magazineSlug = this.$route.params.slug

        this.$http.get(`/admin/mappings/view_mappings/${magazineSlug}`).then(res => {
            this.mappingData = res.data
        })
    },

  setup() {
    const mappingData = ref({})
    const MAPPING = 'app-mapping'

    // Register module
    if (!store.hasModule(MAPPING)) store.registerModule(MAPPING, mappingStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(MAPPING)) store.unregisterModule(MAPPING)
    })

    // http.get('app-mapping/fetchMapping', magazineSlug)
    //   .then(response => { mappingData.value = response.data })
    //   .catch(error => {
    //     if (error.response.status === 404) {
    //       mappingData.value = undefined
    //     }
    //   })
      const leadTypeOptions = [
          { label: 'UK', value: 1 },
          { label: 'USA', value: 2 },
      ]

      const statusOptions = [
          {label: 'Pending', value: '2'},
          {label: 'Active', value: '1'},
          {label: 'Inactive', value: '0'},
      ]


    return {
      mappingData,
        statusOptions,
        leadTypeOptions,

    }
  },
}
</script>

<style>

</style>
