export default [
    {
        path: '/dashboard/admin/uk',
        name: 'admin-dashboard-leads-uk',
        component: () => import('@/views/dashboard/admin/uk/Ecommerce.vue'),
        meta: {
            // adminAuth: true,
            // requiresAuth: true,
        }
    },
    {
        path: '/dashboard/admin/us',
        name: 'admin-dashboard-leads-us',
        component: () => import('@/views/dashboard/admin/us/Ecommerce.vue'),
        meta: {
            // adminAuth: true,
            // requiresAuth: true,
        }
    },
    {
        path: '/dashboard/offer',
        name: 'dashboard-offer',
        component: () => import('@/views/dashboard/offer/Ecommerce.vue'),
        meta: {
            // adminAuth: true,
            // requiresAuth: true,
        }
    },


]
// meta: { guestOnly: true }
