<template>
  <b-card
    v-if="tableData"
    no-body
    class="card-company-table"
  >
    <b-table
      :items="tableData"
      responsive
      :fields="fields"
      class="mb-0"
    >
      <!-- company -->
      <template #cell(subid)="data">
        <div class="d-flex align-items-center">
            <div class="font-weight-bolder">


             <b-badge class-="light-primary">
                 {{ data.item.subid }}
             </b-badge>
            </div>
            <div class="font-small-2 text-muted">
<!--              {{ data.item.subtitle }}-->
            </div>
          </div>
      </template>


      <!-- views -->
        <!-- company -->
        <template #cell(tier)="data">
            <div class="d-flex align-items-center">
                <div class="font-weight-bolder">


                    <b-badge varient-="light-primary">
                        {{ data.item.tier }}
                    </b-badge>
                </div>
                <div class="font-small-2 text-muted">
                    <!--              {{ data.item.subtitle }}-->
                </div>
            </div>
        </template>


        <!-- revenue -->
      <template #cell(vidLeadPrice)="data">
        {{ '£'+data.item.vidLeadPrice }}
      </template>

<!--         profit-->
        <template #cell(isredirected)="data">

            <span v-if="data.item.isRedirected == 1" class="text-success bold">
               100%
            </span>
            <span v-else="data.item.isRedirected == 0" class="text-red bold">
                  0%
            </span>

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
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      fields: [
        { key: 'subid', label: 'AFFILIATE' },
        { key: 'tier', label: 'BUYER' },
        { key: 'vidLeadPrice', label: 'Price' },
        { key: 'isRedirected', label: 'Redirection' },
        { key: 'views', label: 'Conversion Ratio' },
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
