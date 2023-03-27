<template>
    <div>

        <!-- Media -->
        <b-media class="mb-2">
<!--            <template #aside>-->
<!--                <b-avatar-->
<!--                    ref="previewEl"-->
<!--                    :src="mappingTierData.mapping.mapping.avatar"-->
<!--                    :text="avatarText(mappingTierData.mapping.mapping.name)"-->
<!--                    :variant="`light-${resolveMappingTierRoleVariant(mappingTierData.mapping.mapping.role)}`"-->
<!--                    size="90px"-->
<!--                    rounded-->
<!--                />-->
<!--            </template>-->
            <h4 class="mb-1">
                {{ mappingTierData.mapping.partner[0].vendor_id }}
            </h4>
        </b-media>

        <!-- User Info: Input Fields -->
        <b-form
            @submit.prevent="updateMappingTierForm"
        >
            <b-row>

                <!-- Field: Lead Type -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Lead Type"
                        label-for="leadtype"
                    >
                        <v-select
                            v-model="mappingTierData.mapping.mapping.leadtype"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="leadTypeOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="leadtype"
                        />
                    </b-form-group>
                </b-col>
                <!-- Partner ID-->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Partner ID"
                        label-for="partner_id"
                    >

                        <b-form-select v-model="mappingTierData.mapping.mapping.partner_id">
                            <option v-for="option in mappingTierData.mapping.partner_ids" :key="option.vid" :value="option.id">
                                {{ option.vendor_id }}
                            </option>
                        </b-form-select>
                        <!--                <span>Selected: {{ selected }}</span>-->
                    </b-form-group>
                </b-col>
                <!-- Tier ID-->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Tier ID"
                        label-for="buyer_setup_id"
                    >

                        <b-form-select v-model="mappingTierData.mapping.mapping.new_tier_id">
                            <option v-for="option in mappingTierData.mapping.tier_ids"
                                    :key="option.buyername"
                                    :value="option.id"
                                    :selected="mappingTierData.mapping.mapping.tier_id"
                            >
                                {{ option.buyername }}
                            </option>
                        </b-form-select>
                        <!--                <span>Selected: {{ selected }}</span>-->
                    </b-form-group>
                </b-col>
                <!-- Field: Status -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Status"
                        label-for="status"
                    >
                        <v-select
                            v-model="mappingTierData.mapping.mapping.status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="status"
                        />
                    </b-form-group>
                </b-col>



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
                variant="outline-primary"
                class="ml-1"
                @click="goBack"
            >
                Back
            </b-button>

        </b-form>

    </div>
</template>

<script>
    import {
        BButton,
        BFormSelect,
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
    import useMappingTierList from '../mapping-tier-list/useMappingTierList'
    import store from '@/store'
    import mappingTierStoreModule from '../mappingTierStoreModule'

    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'


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
            BFormSelect,
            ToastificationContent,
        },
        props: {
            mappingTierData: {
                type: Object,
                required: true,
            },
        },
        setup(props) {

            const toast = useToast()
            const MAPPING_TIER = 'app-mapping-tier'

            // Register module
            if (!store.hasModule(MAPPING_TIER)) store.registerModule(MAPPING_TIER, mappingTierStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(MAPPING_TIER)) store.unregisterModule(MAPPING_TIER)
            })

            const {
                resolveMappingTierRoleVariant,
                resolveMappingTierStatusVariant,
                statusOptions,
                leadTypeOptions,
                goBack
            } = useMappingTierList()


            const loading = ref(false);
            const errors = ref({});
            const refInputEl = ref(null)
            const previewEl = ref(null)
            const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
                // eslint-disable-next-line no-param-reassign
                props.mappingTierData.mapping.avatar = base64
            })


            function updateMappingTierForm(ev) {
                ev.preventDefault();
                console.log(ev)
                // debugger

                // loading.value = true;

                // console.log(props.mappingTierData.mapping.mapping)
                // debugger
                store.dispatch("app-mapping-tier/updateMappingTier",  props.mappingTierData.mapping.mapping )
                    .then((res) => {
                        // console.log(res)
                        // debugger
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Mapping updated successfully',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                        // loading.value = false;
                        // router.push({
                        //     name: "Dashboard",
                        // });
                    })
                    .catch((error) => {
                        // loading.value = false;
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Error updating Mapping',
                                icon: 'AlertTriangleIcon',
                                variant: 'danger',
                            },
                        })

                        if (error.response.status === 404) {
                            errors.value = error.response.data.errors;
                        }
                    });
            }


            return {
                resolveMappingTierRoleVariant,
                resolveMappingTierStatusVariant,
                avatarText,

                statusOptions,
                leadTypeOptions,
                // partnerOptions,
                // tierOptions,
                // buyerOptions,

                refInputEl,
                previewEl,
                inputImageRenderer,
                updateMappingTierForm,
                toast,
                goBack,
                ToastificationContent,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
