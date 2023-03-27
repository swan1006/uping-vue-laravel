export default [
    {
        header: 'Tech Area',
    },

    {
        title: 'Tech',
        icon: 'UserIcon',
        children: [
            {
                title: 'Horizon',
                route: 'apps-horizon',
            },
            {
                title: 'Telescope',
                route: 'apps-telescope',
            },
        ],
    },
    {
        title: 'API Docs',
        icon: 'CodeIcon',
        children: [
            {
                title: 'UK Docs',
                route: 'admin-api-docs-uk',
            },
            {
                title: 'US Docs',
                route: 'admin-api-docs-us',
            },
        ],
    },

]
