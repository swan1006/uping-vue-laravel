<template>
    <div>

        <!-- Form: Personal Info Form -->
        <b-col
            cols="12"
            class="mb-2"
        >
            <h3>
               Income Cycle
            </h3>
            <small class="text-muted">
                Filter Settings
            </small>
        </b-col>

        <b-col
            cols="12"
            md="12"
            lg="12"
        >
            <b-form-group
                label="Should Be Any Of"
                label-for="contact-options"
                label-class="mb-1"
            >
                <b-form-checkbox-group
                    id="shouldBeAnyOf"
                    name="shouldBeAnyOf"
                    v-model="filterData.object.shouldBeAnyOf"
                    :options="incomeCycleOptions"
                    :checked="filterData.object.shouldBeAnyOf"
                />
            </b-form-group>
        </b-col>




        <b-col
            cols="12"
            md="12"
            lg="12"
        >
            <b-form-group
                label="Should Be Exactly"
                label-for="contact-options"
                label-class="mb-1"
            >
                <b-form-checkbox-group
                    id="shouldBe"
                    name="shouldBe"
                    v-model="filterData.object.shouldBe"
                    :options="incomeCycleOptions"
                    :checked="filterData.object.shouldBe"
                />
            </b-form-group>
        </b-col>
    </div>
</template>

<script>
    import { BRow, BCol, BForm, BFormGroup, BFormInput, BFormRadioGroup, BFormCheckboxGroup, BButton } from 'bootstrap-vue'
    import flatPickr from 'vue-flatpickr-component'
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BForm,
            BFormGroup,
            flatPickr,
            BFormInput,
            vSelect,
            BFormRadioGroup,
            BFormCheckboxGroup,
            BButton,
        },
        props: {
            filterData: {
                type: Object,
                required: true,
            },
            incomeCycleOptions: {
                type: Array,
                required: true,
            },
        },

        setup() {



            return {
                filterData,
                incomeCycleOptions,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
