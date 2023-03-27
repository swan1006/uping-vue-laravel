<template>
    <div>

        <!-- Form: Personal Info Form -->

        <b-col
            cols="12"
            class="mb-2"
        >
            <h3>
                Email
            </h3>
            <small class="text-muted">
                Filter Settings
            </small>
        </b-col>

        <!-- shouldContain-->
        <!-- shouldEndWith-->
        <tab-content
            <b-row>
                <b-col
                    cols="6"
                    class="mb-2"
                >
                    <b-form-group
                        label="Should Contain"
                        label-for="i-username"
                    >
                        <b-form-input
                            id="shouldContain"
                            name="shouldContain"
                            placeholder="gmail"
                            v-model="filterData.object.shouldContain"
                        />
                    </b-form-group>
                </b-col>

                <b-col
                    cols="6"
                    class="mb-2"
                >
                    <small class="text-muted">

                    </small>
                    <b-form-group
                        label="Should End With"
                        label-for="i-username"
                    >
                        <b-form-input
                            id="shouldEndWith"
                            name="shouldEndWith"
                            placeholder=".com"
                            v-model="filterData.object.shouldEndWith"
                        />
                    </b-form-group>
                </b-col>

            </b-row>


        <!-- Should Be Equal To -->

            <b-row>
                <b-col
                    cols="6"
                    class="mb-2"
                >
                    <small class="text-muted">

                    </small>
                    <b-form-group
                        label="Should Be Equal To"
                        label-for="i-username"
                    >
                        <b-form-input
                            id="shouldBe"
                            name="shouldBe"
                            placeholder="1000"
                            v-model="filterData.object.shouldBe"
                        />
                    </b-form-group>
                </b-col>
            </b-row>


        <!-- shouldNotContain-->
        <!-- shouldNotEndWith-->
            <b-row>
                <b-col
                    cols="6"
                    class="mb-2"
                >
                    <b-form-group
                        label="Should Not Contain"
                        label-for="i-username"
                    >
                        <b-form-input
                            id="shouldNotContain"
                            name="shouldNotContain"
                            placeholder="gmail"
                            v-model="filterData.object.shouldNotContain"
                        />
                    </b-form-group>
                </b-col>

                <b-col
                    cols="6"
                    class="mb-2"
                >
                    <small class="text-muted">

                    </small>
                    <b-form-group
                        label="Should Not End With"
                        label-for="i-username"
                    >
                        <b-form-input
                            id="shouldNotEndWith"
                            name="shouldNotEndWith"
                            placeholder=".com"
                            v-model="filterData.object.shouldNotEndWith"
                        />
                    </b-form-group>
                </b-col>

            </b-row>



    </div>
</template>

<script>
    import { BRow, BCol, BForm, BFormGroup, BFormInput, BFormRadioGroup, BFormCheckboxGroup, BButton } from 'bootstrap-vue'
    import flatPickr from 'vue-flatpickr-component'
    import { ref } from '@vue/composition-api'
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
        },

        setup() {




            return {
                // filterData,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
