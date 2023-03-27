<template>
  <b-card
    v-if="tableData"
    no-body
    class="card-company-table"
  >


    <b-table
      :items="tableData.dashboard_data.affiliate_table_data"
      responsive
      :fields="fields"
      class="mb-0"
    >
      <!-- company -->
      <template #cell(vid)="data">
        <div class="d-flex align-items-center">
            <div class="font-weight-bolder">


             <b-badge class-="light-primary">
                 {{ data.item.vid }}
             </b-badge>
            </div>
            <div class="font-small-2 text-muted">
<!--              {{ data.item.subtitle }}-->
            </div>
          </div>
      </template>

      <!-- category -->
<!--      <template #cell(category)="data">-->
<!--        <div class="d-flex align-items-center">-->
<!--          <b-avatar-->
<!--            class="mr-1"-->
<!--            :variant="data.item.avatarColor"-->
<!--          >-->
<!--            <feather-icon-->
<!--              size="18"-->
<!--              :icon="data.item.avatarIcon"-->
<!--            />-->
<!--          </b-avatar>-->
<!--          <span>{{ data.item.avatarTitle }}</span>-->
<!--        </div>-->
<!--      </template>-->

      <!-- views -->
      <template #cell(clicks)="data">
        <div class="d-flex flex-column">
          <span class="font-weight-bolder mb-25">{{ data.item.clicks }}</span>
<!--          <span class="font-small-2 text-muted text-nowrap">{{ data.item.viewsub }}</span>-->
        </div>
      </template>

        <template #cell(conversions)="data">
        <div class="d-flex flex-column">
          <span class="font-weight-bolder mb-25">{{ data.item.conversions }}</span>
<!--          <span class="font-small-2 text-muted text-nowrap">{{ data.item.viewsub }}</span>-->
        </div>
      </template>

      <!-- revenue -->
      <template #cell(revenue)="data">
        {{ '£'+data.item.revenue }}
      </template>

        <!-- profit -->
        <template #cell(profit)="data">

            <span class="text-success bold">
                 {{ '£'+data.item.revenue }}
            </span>
        </template>



      <!-- sales -->
      <template #cell(ratio)="data">
        <div class="d-flex align-items-center">
          <span class="font-weight-bolder mr-1">{{ data.item.sales+'%' }}</span>
          <feather-icon
            :icon="data.item.loss ? 'TrendingDownIcon':'TrendingUpIcon'"
            :class="data.item.loss ? 'text-danger':'text-success'"
          />
        </div>
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
        { key: 'vid', label: 'AFFILIATE' },
        { key: 'clicks', label: 'CLICKS' },
        { key: 'conversions', label: 'CONVERSIONS' },
        { key: 'revenue', label: 'REVENUE' },
        { key: 'profit', label: 'PROFIT' },
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
