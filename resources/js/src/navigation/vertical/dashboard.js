export default [
    {
        title: 'Dashboard',
        icon: 'HomeIcon',
        children: [
            {
                title: 'Leads',
                children: [
                    {
                        title: 'UK',
                        route: 'admin-dashboard-leads-uk',
                        // meta: { requiresAuth: true }
                    },
                    {
                        title: 'USA',
                        route: 'admin-dashboard-leads-us',
                    },
                ],
            },
            {
                title: 'Offer',
                route: 'dashboard-offer',
            },
        ],
    },
]
