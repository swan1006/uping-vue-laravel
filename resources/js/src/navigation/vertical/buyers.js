export default [
    {
        header: 'Buyers List',
    },

    {
        title: 'Buyers',
        icon: 'UsersIcon',
        children: [
            {
                title: 'List',
                route: 'apps-buyers-list',
            },

        ],
    },
    {
        title: 'Buyer Tiers',
        icon: 'ListIcon',
        children: [
            {
                title: 'List',
                route: 'apps-buyer-tier-list',
            },
        ],
    },

    {
        title: 'Filters',
        icon: 'FilterIcon',
        children: [
            {
                title: 'List',
                route: 'apps-buyer-filter-list',
            },
        ],
    },

]
