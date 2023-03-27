<template>
  <b-sidebar
    id="add-new-tier-sidebar"
    :visible="isAddNewBuyerTierSidebarActive"
    bg-variant="white"
    sidebar-class="sidebar-lg"
    shadow
    backdrop
    no-header
    right
    @hidden="resetForm"
    @change="(val) => $emit('update:is-add-new-buyer-tier-sidebar-active', val)"
  >
    <template #default="{ hide }">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
        <h5 class="mb-0">
          Add New Tier
        </h5>

        <feather-icon
          class="ml-1 cursor-pointer"
          icon="XIcon"
          size="16"
          @click="hide"
        />

      </div>

      <!-- BODY -->
      <validation-observer
        #default="{ handleSubmit }"
        ref="refFormObserver"
      >
        <!-- Form -->
        <b-form
          class="p-2"
          @submit.prevent="handleSubmit(onSubmit)"
          @reset.prevent="resetForm"
        >

          <!-- Tier Name -->
          <validation-provider
            #default="validationContext"
            name="buyername"
            rules="required"
          >
            <b-form-group
              label="Tier Name"
              label-for="buyername"
            >
              <b-form-input
                id="buyername"
                v-model="buyerTierData.buyername"
                autofocus
                :state="getValidationState(validationContext)"
                trim
                placeholder="Tier 1ABC"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

            <!-- Lead Type -->
            <validation-provider
                #default="validationContext"
                name="leadtype"
                rules="required"
            >
                <b-form-group
                    label="Lead Type"
                    label-for="leadtype"
                    :state="getValidationState(validationContext)"
                >
                    <v-select
                        v-model="buyerTierData.leadtype"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="lead_type_options"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="leadtype"
                    />
                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Tier Price -->
            <validation-provider
                #default="validationContext"
                name="tier_price"
                rules="required"
            >
                <b-form-group
                    label="Tier Price"
                    label-for="tier_price"
                >
                    <b-form-input
                        id="tier_price"
                        v-model="buyerTierData.tier_price"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="10.00"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Model Type -->
            <validation-provider
                #default="validationContext"
                name="model_type"
                rules="required"
            >
                <b-form-group
                    label="Model Type"
                    label-for="model_type"
                    :state="getValidationState(validationContext)"
                >
                    <v-select
                        v-model="buyerTierData.model_type"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="model_type_options"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="model_type"
                    />
                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Posting Order -->
            <validation-provider
                #default="validationContext"
                name="posting_order"
                rules="required"
            >
                <b-form-group
                    label="Posting Order"
                    label-for="posting_order"
                >
                    <b-form-input
                        id="posting_order"
                        v-model="buyerTierData.posting_order"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="1"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Parameter 1 -->
            <validation-provider
                #default="validationContext"
                name="parameter1"
            >
                <b-form-group
                    label="Parameter 1"
                    label-for="parameter1"
                >
                    <b-form-input
                        id="parameter1"
                        v-model="buyerTierData.parameter1"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="Parameter 1"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Parameter 2-->
            <validation-provider
                #default="validationContext"
                name="parameter2"
            >
                <b-form-group
                    label="Parameter 2"
                    label-for="parameter2"
                >
                    <b-form-input
                        id="parameter2"
                        v-model="buyerTierData.parameter2"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="Parameter 2"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Parameter 3 -->
            <validation-provider
                #default="validationContext"
                name="parameter3"
            >
                <b-form-group
                    label="Parameter 3"
                    label-for="parameter3"
                >
                    <b-form-input
                        id="parameter3"
                        v-model="buyerTierData.parameter3"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="Parameter 3"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>


            <!-- Ping URL Test -->
            <validation-provider
                #default="validationContext"
                name="ping_url_test"
                rules="required"
            >
                <b-form-group
                    label="Ping URL Test"
                    label-for="ping_url_test"
                >
                    <b-form-input
                        id="ping_url_test"
                        v-model="buyerTierData.ping_url_test"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="https://www.google.com/test"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Post URL Test -->
            <validation-provider
                #default="validationContext"
                name="post_url_test"
                rules="required"
            >
                <b-form-group
                    label="Ping URL Live"
                    label-for="post_url_test"
                >
                    <b-form-input
                        id="post_url_test"
                        v-model="buyerTierData.post_url_test"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="https://www.google.com/test"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Ping URL Live -->
            <validation-provider
                #default="validationContext"
                name="ping_url_live"
                rules="required"
            >
                <b-form-group
                    label="Ping URL Live"
                    label-for="ping_url_live"
                >
                    <b-form-input
                        id="ping_url_live"
                        v-model="buyerTierData.ping_url_live"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="https://www.google.com/live"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Post URL Live -->
            <validation-provider
                #default="validationContext"
                name="post_url_live"
                rules="required"
            >
                <b-form-group
                    label="Ping URL Live"
                    label-for="post_url_live"
                >
                    <b-form-input
                        id="post_url_live"
                        v-model="buyerTierData.post_url_live"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="https://www.google.com/live"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

            <!-- Timeout -->
            <validation-provider
                #default="validationContext"
                name="timeout"
                rules="required"
            >
                <b-form-group
                    label="Timeout"
                    label-for="timeout"
                >
                    <b-form-input
                        id="timeout"
                        v-model="buyerTierData.timeout"
                        autofocus
                        :state="getValidationState(validationContext)"
                        trim
                        placeholder="55"
                    />

                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>


          <!-- Mode -->
          <validation-provider
            #default="validationContext"
            name="Mode"
            rules="required"
          >
            <b-form-group
              label="Mode"
              label-for="mode"
              :state="getValidationState(validationContext)"
            >
              <v-select
                v-model="buyerTierData.mode"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="mode_options"
                :reduce="val => val.value"
                :clearable="false"
                input-id="mode"
              />
              <b-form-invalid-feedback :state="getValidationState(validationContext)">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

            <!-- Rotate -->
            <validation-provider
                #default="validationContext"
                name="rotate"
                rules="required"
            >
                <b-form-group
                    label="Rotation"
                    label-for="rotate"
                    :state="getValidationState(validationContext)"
                >
                    <v-select
                        v-model="buyerTierData.rotate"
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :options="rotate_options"
                        :reduce="val => val.value"
                        :clearable="false"
                        input-id="rotate"
                    />
                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>

          <!-- Form Actions -->
          <div class="d-flex mt-2">
            <b-button
              v-ripple.400="'rgba(255, 255, 255, 0.15)'"
              variant="primary"
              class="mr-2"
              type="submit"
            >
              Add
            </b-button>
            <b-button
              v-ripple.400="'rgba(186, 191, 199, 0.15)'"
              type="button"
              variant="outline-secondary"
              @click="hide"
            >
              Cancel
            </b-button>
          </div>

        </b-form>
      </validation-observer>
    </template>
  </b-sidebar>
</template>

<script>
import { BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton } from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref } from '@vue/composition-api'
import { required, alphaNum, email } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import countries from '@/@fake-db/data/other/countries'
import store from '@/store'

export default {
  components: {
    BSidebar,
    BForm,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BButton,
    vSelect,

    // Form Validation
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  model: {
    prop: 'isAddNewBuyerTierSidebarActive',
    event: 'update:is-add-new-buyer-tier-sidebar-active',
  },
  props: {
    isAddNewBuyerTierSidebarActive: {
      type: Boolean,
      required: true,
    },
    leadTypeOptions: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      required,
      alphaNum,
      email,
      countries,
    }
  },
  setup(props, { emit }) {
    const blankBuyerTierData = {
      leadtype: '',
      buyername: '',
      tier_price: '',
      model_type: null,
      posting_order: null,
        parameter1: '',
        parameter2: '',
        parameter3: '',
        ping_url_test: '',
        post_url_test: '',
        ping_url_live: '',
        post_url_live: '',
        timeout: '',
        mode: '',
        status: '',
        rotate: '',
    }

    const buyerTierData = ref(JSON.parse(JSON.stringify(blankBuyerTierData)))
    const resetbuyerTierData = () => {
      buyerTierData.value = JSON.parse(JSON.stringify(blankBuyerTierData))
    }
      const onSubmit = () => {
          store.dispatch('app-buyer-tier/addTier', buyerTierData.value).then(() => {
              emit('refetch-data')
              emit('update:is-add-new-tier-sidebar-active', false)
          })
      }

      const lead_type_options = [
          { label: 'UK', value: 1 },
          { label: 'US', value: 2 },
      ]
      const mode_options = [
          { label: 'Test', value: 0 },
          { label: 'Live', value: 1 },
      ]
      const model_type_options = [
          { label: 'CPA', value: 1 },
          { label: 'CPL', value: 2 },
          { label: 'CPF', value: 3 },
          { label: 'Pingtree', value: 4 },
          { label: 'Hybrid CPL/CPF', value: 5 },
      ]
      const rotate_options = [
          { label: 'CPA', value: 1 },
          { label: 'CPL', value: 2 },
      ]



    const { refFormObserver, getValidationState, resetForm } = formValidation(resetbuyerTierData)

    return {
      buyerTierData,
      onSubmit,

      refFormObserver,
      getValidationState,
      resetForm,
      mode_options,
      lead_type_options,
      model_type_options,
      rotate_options
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';

#add-new-tier-sidebar {
  .vs__dropdown-menu {
    max-height: 200px !important;
  }
}
</style>
