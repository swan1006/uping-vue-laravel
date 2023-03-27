<template>
    <b-card
        no-body
        class="card-browser-states"
    >
        <b-card-header>
            <div>
                <!--                <b-card-title>Lender Redirection Rates</b-card-title>-->
                <b-card-text class="font-small-2">
                    <h6>
                        Lender Redirection Rates

                    </h6>


                </b-card-text>
            </div>

            <b-dropdown
                variant="link"
                no-caret
                class="chart-dropdown"
                toggle-class="p-0"
            >
                <template #button-content>
                    <feather-icon
                        icon="MoreVerticalIcon"
                        size="18"
                        class="text-body cursor-pointer"
                    />
                </template>
                <b-dropdown-item href="#">
                    Last 28 Days
                </b-dropdown-item>
                <b-dropdown-item href="#">
                    Last Month
                </b-dropdown-item>
                <b-dropdown-item href="#">
                    Last Year
                </b-dropdown-item>
            </b-dropdown>
        </b-card-header>

        <!-- body -->
        <b-card-body>

            <div
                v-for="(browser,index) in redirectData.lender_redirection"
                :key="browser.browserImg"
                class="browser-states"
            >
                <b-media no-body>
                    <b-media-body>
                        <b-badge variant="light-primary" >
                            {{ browser.tier_name }}
                        </b-badge>
                    </b-media-body>
                </b-media>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold text-body-heading mr-1">{{ browser.redirect_ratio + '%' }}</span>
                    <vue-apex-charts
                        type="radialBar"
                        height="30"
                        width="30"
                        :options="chart.options"
                        :series="[browser.redirect_ratio]"
                    />
                </div>
            </div>
        </b-card-body>
        <!--/ body -->
    </b-card>
</template>

<script>
    import {
        BCard, BCardHeader, BCardTitle, BCardText, BCardBody, BMedia, BMediaAside, BMediaBody, BImg, BDropdown, BDropdownItem,BBadge
    } from 'bootstrap-vue'
    import VueApexCharts from 'vue-apexcharts'
    import { $themeColors } from '@themeConfig'
    /* eslint-disable global-require */
    const $trackBgColor = '#e9ecef'
    export default {
        components: {
            BCard,
            BCardHeader,
            BCardTitle,
            BCardText,
            BCardBody,
            BMedia,
            BMediaAside,
            BMediaBody,
            BImg,
            BDropdown,
            BDropdownItem,
            VueApexCharts,
            BBadge
        },
        props: {
            redirectData: {
                type: Object
            }
        },
        data() {
            return {
                chartData: [],
                chartClone: {},
                chartColor: [$themeColors.success, $themeColors.warning, $themeColors.danger],
                chartSeries: [54.4, 6.1, 14.6, 4.2],
                browserData: [
                    {
                        name: 'AFF_1234',
                        usage: '54.4%',
                    },
                    {
                        name: 'AFF_133',
                        usage: '6.1%',
                    },
                    {
                        name: 'AFF_1222',
                        usage: '14.6%',
                    },
                ],
                chart: {
                    series: [65],
                    options: {
                        grid: {
                            show: false,
                            padding: {
                                left: -15,
                                right: -15,
                                top: -12,
                                bottom: -15,
                            },
                        },
                        colors: [$themeColors.primary],
                        plotOptions: {
                            radialBar: {
                                hollow: {
                                    size: '22%',
                                },
                                track: {
                                    background: $trackBgColor,
                                },
                                dataLabels: {
                                    showOn: 'always',
                                    name: {
                                        show: false,
                                    },
                                    value: {
                                        show: false,
                                    },
                                },
                            },
                        },
                        stroke: {
                            lineCap: 'round',
                        },
                    },
                },
            }
        },
        created() {
            for (let i = 0; i < this.browserData.length; i += 1) {
                const chartClone = JSON.parse(JSON.stringify(this.chart))
                chartClone.options.colors[0] = this.chartColor[i]
                chartClone.series[0] = this.chartSeries[i]
                this.chartData.push(chartClone)
            }
        },
    }
</script>
