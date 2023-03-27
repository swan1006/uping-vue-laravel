<template>
  <b-card
    no-body
    class="border-primary"
  >
    <b-card-header class="d-flex justify-content-between align-items-center pt-75 pb-25">
      <h5 class="mb-0">
        Company Info
      </h5>
      <b-badge variant="light-primary">
          Join date: July 22, 2021
      </b-badge>
      <small class="text-muted w-100"></small>
    </b-card-header>

    <b-card-body>
      <ul class="list-unstyled my-1">
          <li>
          <span class="align-middle">Buyer ID: LEND_2134</span>
        </li>
          <li>
              <span class="align-middle">Name: {{buyerData.buyer.company.name}}</span>
          </li>
        <li class="my-25">
          <span class="align-middle">Email: {{buyerData.buyer.company.email}}</span>
        </li>
        <li>
          <span class="align-middle">Phone: {{buyerData.buyer.company.phone}}</span>
        </li>
          <li>
              <span class="align-middle">Account Contact: {{buyerData.buyer.account_contact1}}</span>
          </li>

          <li>
              <span class="align-middle">Finance Contact: {{buyerData.buyer.account_contact2}}</span>
          </li>

      </ul>
<!--      <b-button-->
<!--        v-ripple.400="'rgba(255, 255, 255, 0.15)'"-->
<!--        variant="primary"-->
<!--        block-->
<!--        class="mt-2"-->
<!--      >-->
<!--        Update Info-->
<!--      </b-button>-->
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BBadge, BButton,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'

export default {
  directives: {
    Ripple,
  },
    props: {
        buyerData: {
            type: Object,
            required: true,
        },
    },

  components: {
    BCard,
    BCardHeader,
    BCardBody,
    BBadge,
    BButton,
  },
}
</script>

<style>

</style>
