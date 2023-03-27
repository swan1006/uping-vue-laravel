<template>
    <div>



        <!-- User Info: Input Fields -->
        <b-form
            @submit.prevent="updateFilterForm">
            <b-row>

                <!-- Field: Filter Type -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Filter Type"
                        label-for="filter_type"
                    >

                            <b-form-select v-model="filterData.filter_type">
                                <option v-for="option in filterTypeOptions" :key="option.label" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </b-form-select>
                        </b-form-group>
                </b-col>


                <!--                 Field: Tier ID-->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Tier ID"
                        label-for="tier_id"
                    >
                        <b-form-select v-model="filterData.tier_id">
                            <option v-for="option in selectOptions.buyerFilter.tier_ids" :key="option.buyername" :value="option.id">
                                {{ option.buyername }}
                            </option>
                        </b-form-select>
                    </b-form-group>
                </b-col>

                <!-- Field: Conversion Type -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Conversion Type"
                        label-for="conversion_type"
                    >
                        <b-form-select v-model="filterData.conversion_type">
                            <option v-for="option in conversionTypeOptions" :key="option.label" :value="option.value">
                                {{ option.label }}
                            </option>
                        </b-form-select>

                    </b-form-group>
                </b-col>

                <!-- Field: Status -->
                <b-col
                    cols="12"
                    md="4"
                >
                    <b-form-group
                        label="Status"
                        label-for="user-status"
                    >
                        <v-select
                            v-model="filterData.status"
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            :options="statusOptions"
                            :reduce="val => val.value"
                            :clearable="false"
                            input-id="user-status"
                        />
                    </b-form-group>
                </b-col>


            </b-row>


            <b-button
                variant="primary"
                class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                type="submit"
            >
                Save Changes
            </b-button>
            <b-button
                variant="outline-primary"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
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
        BFormSelect
    } from 'bootstrap-vue'
    import {avatarText} from '@core/utils/filter'
    import vSelect from 'vue-select'
    import {useInputImageRenderer} from '@core/comp-functions/forms/form-utils'
    import {onUnmounted, ref} from '@vue/composition-api'
    import useFilterList from '../filter-list/useFilterList'
    import store from '@/store'
    import filterStoreModule from '../filterStoreModule'

    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BButton,
            BMedia,
            BAvatar,
            BRow,
            BCol,
            BFormInput,
            BForm,
            BTable,
            BCard,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            vSelect,
            BFormSelect,
            BFormGroup,
            ToastificationContent,
        },
        props: {
            filterData: {
                type: Object,
                required: true,
            },
        },
        setup(props) {


            const FILTERS = 'app-filters'
            const loading = ref(false);
            const errors = ref({});
            const selectOptions = ref();
            const filterData = ref(null);


            // Register module
            if (!store.hasModule(FILTERS)) store.registerModule(FILTERS, filterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(FILTERS)) store.unregisterModule(FILTERS)
            })

            const {goBack, toast, roleOptions, statusOptions, tierOptions,filterTypeOptions,  conversionTypeOptions,buyerOptions} = useFilterList()




            store.dispatch('app-filters/fetchSelectOptions')
                .then(response => {

                    selectOptions.value = response.data
                })
                .catch(error => {

                    if (error.response.status === 404) {
                        selectOptions.value = undefined
                    }
                })

            function updateFilterForm(ev) {
                ev.preventDefault();
                console.log(ev)
                debugger

                // loading.value = true;

                // console.log(props.userData.user)
                // debugger
                store.dispatch("app-filters/updateFilter",  props.filterData )
                    .then((res) => {
                        console.log(res)
                        debugger
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Filter updated successfully',
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
                                title: 'Error fetching Filter',
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
                updateFilterForm,

                roleOptions,
                statusOptions,
                tierOptions,
                buyerOptions,

                toast,
                filterTypeOptions,
                conversionTypeOptions,
                selectOptions,
                goBack,
                ToastificationContent,

            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
