<template>
    <b-card
        no-body
        class="border-primary"
    >
        <b-card-header class="d-flex justify-content-between align-items-center pt-75 pb-25">
            <h5 class="mb-0">
                Tier Settings
            </h5>
            <b-badge variant="light-primary">
                Join date: July 22, 2021
            </b-badge>
            <small class="text-muted w-100"></small>
        </b-card-header>

        <b-card-body>
            <ul class="list-unstyled my-1">
                <li>
                    <span class="align-middle">Buyer Tier ID: LEND_2134</span>
                </li>
                <li>
                    <span class="align-middle">Tier Price: {{buyerTierData.buyertier.tier_price}}</span>
                </li>
                <li class="my-25">
                    <span class="align-middle">Timeout: {{buyerTierData.buyertier.timeout}}</span>
                </li>
                <li class="my-25">
                    <span class="align-middle">Post URL: {{buyerTierData.buyertier.post_url_live}}</span>
                </li>



            </ul>
                  <b-button
                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                    variant="primary"
                    block
                    class="mt-2"
                  >
                    Update Settings
                  </b-button>
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
            buyerTierData: {
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
