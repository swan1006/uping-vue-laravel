<template>
  <b-card
    v-if="tableData"
    no-body
    class="card-company-table"
  >


    <b-table
      :items="tableData.dashboard_data.conversion_table_data"
      responsive
      :fields="fields"
      class="mb-0"
    >
      <!-- company -->
      <template #cell(offer_id)="data">
        <div class="d-flex align-items-center">
            <div class="font-weight-bolder">


             <b-badge class-="light-primary">
                 {{ data.item.offer_id }}
             </b-badge>
            </div>
            <div class="font-small-2 text-muted">
            </div>
          </div>
      </template>




        <template #cell(conversion)="data">
        <div class="d-flex flex-column">
          <span class="font-weight-bolder mb-25">{{ data.item.conversion }}</span>
        </div>
      </template>

      <!-- revenue -->
      <template #cell(totalCost)="data">
        {{ '£'+data.item.totalCost }}
      </template>


    </b-table>
  </b-card>
</template>

<script>
import {
  BCard, BTable, BAvatar, BImg, BBadge,
} from 'bootstrap-vue'

export default {
  components: {
    BCard,
    BTable,
    BAvatar,
    BImg,
    BBadge
  },
  props: {
    tableData: {
      type: Object,
      default: () => [],
    },
  },

  data() {
    return {
      fields: [
        { key: 'offer_id', label: 'OFFER ID' },
        { key: 'conversion', label: 'CONVERSIONS' },
        { key: 'totalCost', label: 'COMMISSION' },
      ],
    }
  },
}
</script>

<style lang="scss" scoped>
@import '~@core/scss/base/bootstrap-extended/include';
@import '~@core/scss/base/components/variables-dark';

.card-company-table ::v-deep td .b-avatar.badge-light-company {
  .dark-layout & {
    background: $theme-dark-body-bg !important;
  }
}
</style>
