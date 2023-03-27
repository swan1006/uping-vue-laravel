<template>
  <b-card-body>
    <div class="mt-4 mb-2 text-center">
      <h6>Customize your tracking link</h6>

          <b-badge
                  >
          <!--                        {{ trackingLink }}-->
              <br>
          <h5 class="text-white">
              https://google.com/aff_sub={{trackingLink.aff_sub}}&aff_sub2={{trackingLink.aff_sub}}&aff_sub3={{trackingLink.aff_sub}}&
          </h5>
      </b-badge>
        <div class="mt-4 mb-2 text-center">
<!--        <b-card-code title="">-->
            <b-button-toolbar
                class="demo-inline-spacing"
                aria-label="1234"
            >
                <!--  aff sub-->
                <b-row>

                    <!-- Field: Buyer name -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                    </b-col>
                    <!-- aff_sub-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub2-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub2"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub3-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub3"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub4-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub4"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub5-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub5"
                            />
                        </b-input-group>
                    </b-button-group>
                </b-row>
                <!-- other -->
                <b-row>

                    <!-- Field: Buyer name -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                    </b-col>
                    <!-- aff_sub-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub2-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub2"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub3-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub3"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub4-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub4"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub5-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub5"
                            />
                        </b-input-group>
                    </b-button-group>
                </b-row>
                <b-row>

                    <!-- Field: Buyer name -->
                    <b-col
                        cols="6"
                        md="3"
                    >
                    </b-col>
                    <!-- aff_sub-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub2-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub2"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub3-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub3"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub4-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub4"
                            />
                        </b-input-group>
                    </b-button-group>

                    <!-- aff_sub5-->
                    <b-button-group size="sm">
                        <b-input-group
                            size="sm"
                            prepend="aff_sub"
                        >
                            <b-form-input
                                value=""
                                aria-placeholder="SUB_1234"
                                class="text-right"
                                v-model="trackingLink.aff_sub5"
                            />
                        </b-input-group>
                    </b-button-group>
                </b-row>

            </b-button-toolbar>

    </div>
    </div>


  </b-card-body>
</template>

<script>
    import {
        BButton,
        BButtonGroup,
        BButtonToolbar,
        BCardBody, BCardText, BFormInput, BImg, BInputGroup, BLink, BBadge
    } from 'bootstrap-vue'
    import Ripple from "vue-ripple-directive";
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
    import {ref} from "@vue/composition-api";

export default {
  components: {
    BCardBody,
    BCardText,
    BImg,
    BLink,
      BButtonToolbar,
      BButtonGroup,
      BButton,
      BFormInput,
      BInputGroup,
      BCardCode,
      BBadge

      // 3rd Party
  },
    directives: {
        Ripple,
    },

  setup() {
      const trackingLink = ref({
          aff_sub: '',
          aff_sub2: '',
          aff_sub3: '',
          aff_sub4: '',
          aff_sub5: ''
      })
    const swiperOptions = {
      slidesPerView: 5,
      spaceBetween: 55,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        1600: {
          slidesPerView: 4,
          spaceBetween: 55,
        },
        1300: {
          slidesPerView: 3,
          spaceBetween: 55,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 55,
        },
        320: {
          slidesPerView: 1,
          spaceBetween: 55,
        },
      },
    }

    /* eslint-disable global-require */
    const relatedProducts = [
      {
        name: 'Apple Watch Series 6',
        brand: 'Apple',
        price: 399.98,
        rating: 4,
        image: require('@/assets/images/elements/apple-watch.png'),
      },
      {
        name: 'Apple MacBook Pro - Silver',
        brand: 'Apple',
        price: 2449.49,
        rating: 2,
        image: require('@/assets/images/elements/macbook-pro.png'),
      },
      {
        name: 'Apple HomePod (Space Grey)',
        brand: 'Apple',
        price: 229.29,
        rating: 3,
        image: require('@/assets/images/elements/homepod.png'),
      },
      {
        name: 'Magic Mouse 2 - Black',
        brand: 'Apple',
        price: 90.98,
        rating: 5,
        image: require('@/assets/images/elements/magic-mouse.png'),
      },
      {
        name: 'iPhone 12 Pro',
        brand: 'Apple',
        price: 1559.99,
        rating: 4,
        image: require('@/assets/images/elements/iphone-x.png'),
      },
    ]
    /* eslint-disable global-require */

    return {
      swiperOptions,
      relatedProducts,
      trackingLink
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/swiper.scss';
@import '~swiper/css/swiper.css';
</style>
