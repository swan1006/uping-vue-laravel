export default [
    // DASHBOARDS
    {
        path: '/dashboard/partner/leads/us',
        name: 'dashboard-partner-leads-us',
        component: () => import('@/views/apps/partnerdashboard/dashboard/leads/us/Ecommerce.vue'),
        // partnerAuth: true,
        // requiresAuth: true,
    },
    {
        path: '/dashboard/partner/leads/uk',
        name: 'dashboard-partner-leads-uk',
        component: () => import('@/views/apps/partnerdashboard/dashboard/leads/uk/Ecommerce.vue'),
        // partnerAuth: true,
        // requiresAuth: true,
    },
    {
        path: '/dashboard/partner/offers',
        name: 'dashboard-partner-offers',
        component: () => import('@/views/apps/partnerdashboard/dashboard/offer/Ecommerce.vue'),
        // partnerAuth: true,
        // requiresAuth: true,
    },

    //OFFERS

    {
        path: '/partner/offer/list',
        name: 'apps-partner-offer-list',
        component: () => import('@/views/apps/partnerdashboard/offer/e-commerce-shop/ECommerceShop.vue'),
        meta: {
            contentRenderer: 'sidebar-left-detached',
            contentClass: 'ecommerce-application',
            pageTitle: 'Offers',
            breadcrumb: [
                {
                    text: 'Offers',
                    meta: {
                        requiresAuth: true,
                        adminAuth: true
                    }
                },
                {
                    text: 'List',
                    active: true,
                    meta: {
                        requiresAuth: true,
                        adminAuth: true
                    }
                },
            ],
        },
    },
    {
        path: '/partner/offer/wishlist',
        name: 'apps-partner-offer-wishlist',
        component: () => import('@/views/apps/partnerdashboard/offer/e-commerce-wishlist/ECommerceWishlist.vue'),
        meta: {
            pageTitle: 'Saved Offers',
            contentClass: 'ecommerce-application',
            breadcrumb: [
                {
                    text: 'Offers',
                    meta: {
                        requiresAuth: true,
                        adminAuth: true
                    }
                },
                {
                    text: 'Saved Offers',
                    active: true,
                    meta: {
                        requiresAuth: true,
                        adminAuth: true
                    }
                },
            ],
        },
    },
    {
        path: '/partner/offer/:id',
        name: 'apps-partner-offer-product-details',
        component: () => import('@/views/apps/partnerdashboard/offer/e-commerce-product-details/ECommerceProductDetails.vue'),
        meta: {
            pageTitle: 'Offer Details',
            contentClass: 'ecommerce-application',
            breadcrumb: [
                {
                    text: 'Offer',
                    meta: {
                        requiresAuth: true,
                        adminAuth: true
                    }
                },
                {
                    text: 'List',
                    active: true,
                    meta: {
                        requiresAuth: true,
                        adminAuth: true
                    }
                },
                {
                    text: 'Offer Details',
                    active: true,
                    meta: {
                        requiresAuth: true,
                        adminAuth: true
                    }
                }
            ],
        },
    },

    //REPORTS
    // UK
    {
        path: '/partner/report/uk/list',
        name: 'apps-partner-report-uk-list',
        component: () => import('@/views/apps/partnerdashboard/report/uk/report-list/ReportList.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/uk/view/:id',
        name: 'apps-partner-report-uk-view',
        component: () => import('@/views/apps/partnerdashboard/report/uk/report-view/ReportView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/uk/edit/:id',
        name: 'apps-partner-report-uk-edit',
        component: () => import('@/views/apps/partnerdashboard/report/uk/report-edit/ReportEdit.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    // USA
    {
        path: '/partner/report/us/list',
        name: 'apps-partner-report-us-list',
        component: () => import('@/views/apps/partnerdashboard/report/us/report-list/ReportList.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/us/view/:id',
        name: 'apps-partner-report-us-view',
        component: () => import('@/views/apps/partnerdashboard/report/us/report-view/ReportView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/us/edit/:id',
        name: 'apps-partner-report-us-edit',
        component: () => import('@/views/apps/partnerdashboard/report/us/report-edit/ReportEdit.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    // Offer
    {
        path: '/partner/report/offer/list',
        name: 'apps-partner-report-offer-list',
        component: () => import('@/views/apps/partnerdashboard/report/offer/report-list/ReportList.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/offer/view/:id',
        name: 'apps-partner-report-offer-view',
        component: () => import('@/views/apps/partnerdashboard/report/offer/report-view/ReportView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/offer/edit/:id',
        name: 'apps-partner-report-offer-edit',
        component: () => import('@/views/apps/partnerdashboard/report/offer/report-edit/ReportEdit.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    // Postback
    {
        path: '/partner/report/postback/list',
        name: 'apps-partner-report-postback-list',
        component: () => import('@/views/apps/partnerdashboard/report/postback/report-list/ReportList.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/postback/view/:id',
        name: 'apps-partner-report-postback-view',
        component: () => import('@/views/apps/partnerdashboard/report/postback/report-view/ReportView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/postback/edit/:id',
        name: 'apps-partner-report-postback-edit',
        component: () => import('@/views/apps/partnerdashboard/report/postback/report-edit/ReportEdit.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    // Referral
    {
        path: '/partner/report/referral/list',
        name: 'apps-partner-report-referral-list',
        component: () => import('@/views/apps/partnerdashboard/report/referral/report-list/ReportList.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/referral/view/:id',
        name: 'apps-partner-report-referral-view',
        component: () => import('@/views/apps/partnerdashboard/report/referral/report-view/ReportView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/report/referral/edit/:id',
        name: 'apps-partner-report-referral-edit',
        component: () => import('@/views/apps/partnerdashboard/report/referral/report-edit/ReportEdit.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    // POSTBACKS
    {
        path: '/partner/postback/list',
        name: 'apps-partner-postback-list',
        component: () => import('@/views/apps/partnerdashboard/postback/postback-list/PostbackList.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/postback/view/:id',
        name: 'apps-partner-postback-view',
        component: () => import('@/views/apps/partnerdashboard/postback/postback-view/PostbackView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/postback/edit/:id',
        name: 'apps-partner-postback-edit',
        component: () => import('@/views/apps/partnerdashboard/postback/postback-edit/PostbackEdit.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },

    // API DOCS
    {
        path: '/dashboard/partner/api-docs/uk',
        name: 'dashboard-partner-api-docs-uk',
        component: () => import('@/views/apps/partnerdashboard/api-docs/uk/UKDocsView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/dashboard/partner/api-docs/us',
        name: 'dashboard-partner-api-docs-us',
        component: () => import('@/views/apps/partnerdashboard/api-docs/us/USDocsView.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },

    // INVOICES
    {
        path: '/partner/invoice/list',
        name: 'apps-partner-invoice-list',
        component: () => import('@/views/apps/partnerdashboard/invoices/invoice-list/InvoiceList.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
    {
        path: '/partner/invoice/preview/:id',
        name: 'apps-partner-invoice-preview',
        component: () => import('@/views/apps/partnerdashboard//invoices/invoice-preview/InvoicePreview.vue'),
        meta: {
            requiresAuth: true,
            partnerAuth: true
        }
    },
]
