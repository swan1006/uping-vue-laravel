<template>
    <b-card
        no-body

    >
        <b-card-header class="d-flex justify-content-between align-items-center pt-75 pb-25">
            <h5 class="mb-0">
                <b-badge variant="light-primary">
                    Applicant
                </b-badge>
            </h5>

            <!--      <small class="text-muted w-100">APP ID: {{ leadData.lead.source.id}}</small>-->
        </b-card-header>

        <b-card-body>
            <ul class="list-unstyled my-1">
                <li>
                    <span class="align-middle">Title: {{ leadData.lead.applicant.nameTitle }}</span>
                </li>
                <li class="my-25">
                    <span class="align-middle">First Name: {{ leadData.lead.applicant.firstName }}</span>
                </li>
                <li>
                    <span class="align-middle">Last Name: {{ leadData.lead.applicant.lastName }}</span>
                </li>
                <li>
                    <span class="align-middle">Email: {{ leadData.lead.applicant.email }}</span>
                </li>
                <li>
                    <span class="align-middle">{{ leadData.lead.applicant.dateOfBirthDay }}</span>
                </li>
                <li>
                    <span class="align-middle">{{ leadData.lead.applicant.email }}</span>
                </li>
                <li>
                <span class="align-middle">{{ leadData.lead.applicant.gender }}</span>
                 </li>
                <li>
                    <span class="align-middle">{{ leadData.lead.applicant.mobilePhoneNumber }}</span>
                </li>
                <li>
                    <span class="align-middle">{{ leadData.lead.applicant.workPhoneNumber }}</span>
                </li>

                <li>
                    <span class="align-middle">{{ leadData.lead.applicant.maritalStatus }}</span>
                </li>

                <li>
                    <span class="align-middle">{{ leadData.lead.applicant.dependants }}</span>
                </li>




            </ul>
            <!--      <b-button-->
            <!--        v-ripple.400="'rgba(255, 255, 255, 0.15)'"-->
            <!--        variant="primary"-->
            <!--        block-->
            <!--      >-->
            <!--        Upgrade Plan-->
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
            leadData: {
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
