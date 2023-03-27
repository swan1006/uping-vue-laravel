<template>
    <b-card
    >

        <b-row>

            <!-- PostbackMapping Info: Left col -->
            <b-col
                cols="21"
                xl="6"
                class="d-flex justify-content-between flex-column"
            >
                <!-- PostbackMapping Avatar & Action Buttons -->
                <div class="d-flex justify-content-start">
                    <b-avatar
                        :text="avatarText(postbackData.name)"
                        :variant="`light-${resolvePostbackMappingRoleVariant(postbackData.role)}`"
                        size="104px"
                        rounded
                    />
                    <div class="d-flex flex-column ml-1">
                        <div class="mb-1">
                            <h4 class="mb-0">
                                {{ postbackData.postback.postback_name }}
                            </h4>
                            <span class="card-text">ID: {{ postbackData.postback.id }}</span>
                        </div>
                        <div class="d-flex flex-wrap">
                            <b-button
                                :to="{ name: 'apps-postback-mapping-edit', params: { id: postbackData.postback.id } }"
                                variant="primary"
                                :postback-mapping-data="postbackData"
                            >
                                Edit
                            </b-button>
                            <b-button
                                variant="outline-primary"
                                class="ml-1"
                                @click="goBack" >
                                Back
                            </b-button>
                        </div>
                    </div>
                </div>
            </b-col>

            <!-- Right Col: Table -->
            <b-col
                cols="12"
                xl="6"
            >
                <table class="mt-2 mt-xl-0 w-100">
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="PostbackMappingIcon"
                                class="mr-75"
                            />
                        </th>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Postback Name</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge variant="light-primary">
                               {{postbackData.postback.postback_name }}
                            </b-badge>

                        </td>
                    </tr>

                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Global Postback</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge v-if="postbackData.postback.global == 1" variant="light-primary">
                                Global
                            </b-badge>
                            <b-badge v-else-if="postbackData.postback.global == 0" variant="light-primary">
                                Non Global
                            </b-badge>

                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Offer ID</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge variant="light-secondary">
                                {{postbackData.postback.offer_id }}
                            </b-badge>

                        </td>
                    </tr>

                    <tr>
                        <th class="pb-50">
                            <feather-icon
                                icon="StarIcon"
                                class="mr-75"
                            />
                            <span class="font-weight-bold">Postback URL</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            <b-badge  variant="light-success">
                                {{ postbackData.postback.affiliatePostbackUrl }}
                            </b-badge>

                        </td>
                    </tr>

                </table>
            </b-col>
        </b-row>
    </b-card>
</template>

<script>
    import {
        BCard, BButton, BAvatar, BRow, BCol, BBadge
    } from 'bootstrap-vue'
    import { avatarText } from '@core/utils/filter'
    import usePostbackMappingsList from '../postback-mapping-list/usePostbackMappingList'

    export default {
        components: {
            BCard, BButton, BRow, BCol, BAvatar, BBadge
        },
        props: {
            postbackData: {
                type: Object,
                required: true,
            },
        },
        setup() {

            const { resolvePostbackMappingRoleVariant, goBack } = usePostbackMappingsList()

            return {
                avatarText,
                goBack,
                resolvePostbackMappingRoleVariant,
            }
        },
    }
</script>

<style>

</style>
