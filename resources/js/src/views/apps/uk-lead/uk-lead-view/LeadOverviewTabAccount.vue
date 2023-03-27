<template>
    <div>

        <b-card>
            <!-- Media -->
            <b-media class="mb-2">
                <h5>Recent Loan Applications</h5>
            </b-media>

            <b-table
                responsive
                :items="leadData.recentApplications"
                :fields="fields"
                class="mb-0"
            >
                <template #cell(id)="data">
                  <span class="text-nowrap">
                      <b-badge variant="light-primary">
                              {{ data.item.id }}

                      </b-badge>
                  </span>
                </template>
                <template #cell(lead_id)="data">
                  <span class="text-nowrap">
                      <b-badge variant="light-primary">
                          {{ data.item.lead_id }}
                      </b-badge>
                  </span>
                </template>
                <template #cell(nameTitle)="data">
                  <span class="text-nowrap">
                    {{ data.item.nameTitle }}
                  </span>
                </template>
                <template #cell(firstName)="data">
                  <span class="text-nowrap">
                    {{ data.value.firstName + ' ' +  data.value.lastName }}
                  </span>
                </template>
                <template #cell(email)="data">
                  <span class="text-nowrap">
                    {{ data.item.email }}
                  </span>
                </template>
                <template #cell(ipAddress)="data">
                  <span class="text-nowrap">
                    {{ data.item.ipAddress }}
                  </span>
                </template>
                <template #cell(phone)="data">
                  <span class="text-nowrap">
                    {{ data.item.homePhoneNumber }}
                  </span>
                </template>


                <!-- Optional default data cell scoped slot -->
                <template #cell(actions)="data">
                    <b-badge>
                        View Application
                    </b-badge>
                </template>
            </b-table>


        </b-card>
    </div>

</template>


<script>
    import {
        BButton,
        BMedia,
        BAvatar,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BTab,
        BTabs, BAlert, BLink,BBadge

    } from 'bootstrap-vue'
    import {avatarText} from '@core/utils/filter'
    import vSelect from 'vue-select'
    import {useInputImageRenderer} from '@core/comp-functions/forms/form-utils'
    import {ref} from '@vue/composition-api'
    import useUKLeadsList from '../uk-lead-list/useLeadList'

    export default {
        components: {
            BButton,
            BMedia,
            BAvatar,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            vSelect,
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,
            BBadge,
        },
        props: {
            leadData: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                fields: [
                    { key: 'id',label: 'ID' },
                    { key: 'lead_id',label: 'Lead ID' },
                    { key: 'nameTitle',label: 'Title' },
                    { key: 'first_name',label: 'Full name' },
                    { key: 'email',label: 'Email' },
                    { key: 'ipAddress',label: 'IP Address' },
                    {key: 'Phone', label: 'Phone',},
                    'Actions',
                ],
            }
        },
        setup(props) {
            const {resolveUserRoleVariant} = useUKLeadsList()

            const roleOptions = [
                {label: 'Admin', value: 'admin'},
                {label: 'Author', value: 'author'},
                {label: 'Editor', value: 'editor'},
                {label: 'Maintainer', value: 'maintainer'},
                {label: 'Subscriber', value: 'subscriber'},
            ]

            const statusOptions = [
                {label: 'Pending', value: 'pending'},
                {label: 'Active', value: 'active'},
                {label: 'Inactive', value: 'inactive'},
            ]


            // ? Demo Purpose => Update image on click of update
            const refInputEl = ref(null)
            const previewEl = ref(null)

            const {inputImageRenderer} = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign
                props.leadData.avatar = base64
            })

            return {
                resolveUserRoleVariant,
                avatarText,
                roleOptions,
                statusOptions,

                //  ? Demo - Update Image on click of update button
                refInputEl,
                previewEl,
                inputImageRenderer,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
