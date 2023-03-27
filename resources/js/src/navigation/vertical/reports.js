export default [
    {
        header: 'Reports',
    },

    {
        title: 'Report',
        icon: 'BarChartIcon',
        tagVariant: 'light-warning',
        children: [
            {
                title: 'UK Reports',
                route: 'apps-admin-report-uk-list',
                // meta: { requiresAuth: true }
            },
            {
                title: 'US Reports',
                route: 'apps-admin-report-us-list',
                // meta: { requiresAuth: true }
            },
            {
                title: 'Offer Reports',
                route: 'apps-admin-report-offer-list',
                // meta: { requiresAuth: true }
            },
            {
                title: 'Referral Reports',
                route: 'apps-admin-report-referral-list',
                // meta: { requiresAuth: true }
            },
            {
                title: 'Postback Reports',
                route: 'apps-admin-report-postback-list',
                // meta: { requiresAuth: true }
            },
        ],
    },


]
