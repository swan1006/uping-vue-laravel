<template>
    <div>

        <!-- Media -->
        <b-media class="mb-2">
            <template #aside>
                <b-avatar
                    ref="previewEl"
                    :src="buyerFilterData.buyerFilter.avatar"
                    :text="avatarText(buyerFilterData.buyerFilter.name)"
                    :variant="`light-${resolveBuyerFilterRoleVariant(buyerFilterData.buyerFilter.role)}`"
                    size="90px"
                    rounded
                />
            </template>
            <h4 class="mb-1">
                {{ buyerFilterData.buyerFilter.name }}
            </h4>
            <div class="d-flex flex-wrap">
                <b-button
                    variant="primary"
                    @click="$refs.refInputEl.click()"
                >
                    <input
                        ref="refInputEl"
                        type="file"
                        class="d-none"
                        @input="inputImageRenderer"
                    >
                    <span class="d-none d-sm-inline">Update</span>
                    <feather-icon
                        icon="EditIcon"
                        class="d-inline d-sm-none"
                    />
                </b-button>
                <b-button
                    variant="outline-secondary"
                    class="ml-1"
                >
                    <span class="d-none d-sm-inline">Remove</span>
                    <feather-icon
                        icon="TrashIcon"
                        class="d-inline d-sm-none"
                    />
                </b-button>
            </div>
        </b-media>

        <!-- User Info: Input Fields -->
        <b-form
            @submit.prevent="updateAccountForm"
        >
            <b-row>

                <!-- Field: Username -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Username"
                        label-for="buyerfiltername"
                    >
                        <b-form-input
                            id="buyerfiltername"
                            v-model="buyerFilterData.buyerFilter.buyerFiltername"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Full Name -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Name"
                        label-for="full-name"
                    >
                        <b-form-input
                            id="name"
                            v-model="buyerFilterData.buyerFilter.name"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Email -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Email"
                        label-for="email"
                    >
                        <b-form-input
                            id="email"
                            v-model="buyerFilterData.buyerFilter.email"
                            type="email"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Status -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Status"
                        label-for="buyer-filter-status"
                    >
                        <v-select
                            v-model="buyerFilterData.buyerFilter.status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-filter-status"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Role -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="User Role"
                        label-for="role"
                    >
                        <v-select
                            v-model="buyerFilterData.buyerFilter.role"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="roleOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="buyer-filter-role"
                        />
                    </b-form-group>
                </b-col>

                <!-- Field: Company -->
                <!--        <b-col-->
                <!--          cols="12"-->
                <!--          md="4"-->
                <!--        >-->
                <!--          <b-form-group-->
                <!--            label="Company"-->
                <!--            label-for="company"-->
                <!--          >-->
                <!--            <b-form-input-->
                <!--              id="company"-->
                <!--              v-model="buyerFilterData.buyerFilter.company.name"-->
                <!--            />-->
                <!--          </b-form-group>-->
                <!--        </b-col>-->

            </b-row>


            <!-- Action Buttons -->
            <b-button
                variant="primary"
                class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                type="submit"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
            >
                Save Changes
            </b-button>
            <b-button
                variant="outline-secondary"
                type="reset"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
            >
                Reset
            </b-button>
        </b-form>

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
    } from 'bootstrap-vue'
    import { avatarText } from '@core/utils/filter'
    import vSelect from 'vue-select'
    import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
    import {onUnmounted, ref} from '@vue/composition-api'
    import useBuyerFilterList from '../buyer-filter-list/useBuyerFilterList'
    import store from '@/store'
    import buyerFilterStoreModule from '../buyerFilterStoreModule'



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
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            vSelect,
        },
        props: {
            buyerFilterData: {
                type: Object,
                required: true,
            },
        },
        setup(props) {


            const BUYERFILTER_APP_STORE_MODULE_NAME = 'app-buyer-filters'

            // Register module
            if (!store.hasModule(BUYERFILTER_APP_STORE_MODULE_NAME)) store.registerModule(BUYERFILTER_APP_STORE_MODULE_NAME, buyerFilterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(BUYERFILTER_APP_STORE_MODULE_NAME)) store.unregisterModule(BUYERFILTER_APP_STORE_MODULE_NAME)
            })

            const { resolveBuyerFilterRoleVariant, resolveBuyerFilterStatusVariant , toast, roleOptions, statusOptions} = useBuyerFilterList()


            const loading = ref(false);
            const errors = ref({});






            // ? Demo Purpose => Update image on click of update
            const refInputEl = ref(null)
            const previewEl = ref(null)

            const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign
                props.buyerFilterData.avatar = base64
            })



            function updateAccountForm(ev) {
                ev.preventDefault();
                console.log(ev)
                debugger

                loading.value = true;

                // console.log(props.buyerFilterData.buyerFilter)
                // debugger
                store.dispatch("app-buyer-filters/updateAccountForm",  props.buyerFilterData.buyerFilter )
                    .then((res) => {
                        console.log(res)
                        debugger
                        loading.value = false;
                        // router.push({
                        //     name: "Dashboard",
                        // });
                    })
                    .catch((error) => {
                        loading.value = false;
                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }

            return {
                resolveBuyerFilterRoleVariant,
                resolveBuyerFilterStatusVariant,
                avatarText,
                roleOptions,
                statusOptions,

                refInputEl,
                previewEl,
                inputImageRenderer,
                updateAccountForm,
                toast,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
