export default [
  {
    path: '/error-404',
    name: 'error-404',
    component: () => import('@/views/error/Error404.vue'),
    meta: {
           requiresAuth: false,
      layout: 'full',
      // resource: 'Auth',
      action: 'read',
    },
  },
  {
    path: '/login',
    name: 'auth-login',
    component: () => import('@/views/pages/authentication/Login.vue'),
    meta: {
      layout: 'full',
        adminAuth: false,
        requiresAuth: false,
    },
  },
  {
    path: '/register',
    name: 'auth-register',
    component: () => import('@/views/pages/authentication/Register.vue'),
    meta: {
      layout: 'full',
        adminAuth: false,
        requiresAuth: false,
    },
  },
  {
    path: '/forgot-password',
    name: 'auth-forgot-password',
    component: () => import('@/views/pages/authentication/ForgotPassword.vue'),
    meta: {
           requiresAuth: false,
      layout: 'full',
      resource: 'Auth',
    },
  },
  {
    path: '/pages/authentication/forgot-password-v1',
    name: 'auth-forgot-password-v1',
    component: () => import('@/views/pages/authentication/ForgotPassword-v1.vue'),
    meta: {
           requiresAuth: false,
      layout: 'full',
    },
  },
  {
    path: '/pages/authentication/reset-password-v1',
    name: 'auth-reset-password-v1',
    component: () => import('@/views/pages/authentication/ResetPassword-v1.vue'),
    meta: {
           requiresAuth: false,
      layout: 'full',
    },
  },
  // {
  //   path: '/pages/miscellaneous/coming-soon',
  //   name: 'misc-coming-soon',
  //   component: () => import('@/views/pages/miscellaneous/ComingSoon.vue'),
  //   meta: {
  //          requiresAuth: false,
  //     layout: 'full',
  //   },
  // },
  // {
  //   path: '/pages/miscellaneous/not-authorized',
  //   name: 'misc-not-authorized',
  //   component: () => import('@/views/pages/miscellaneous/NotAuthorized.vue'),
  //   meta: {
  //          requiresAuth: false,
  //     layout: 'full',
  //     resource: 'Auth',
  //   },
  // },
  // {
  //   path: '/pages/miscellaneous/under-maintenance',
  //   name: 'misc-under-maintenance',
  //   component: () => import('@/views/pages/miscellaneous/UnderMaintenance.vue'),
  //   meta: {
  //          requiresAuth: false,
  //     layout: 'full',
  //   },
  // },
  // {
  //   path: '/pages/miscellaneous/error',
  //   name: 'misc-error',
  //   component: () => import('@/views/pages/miscellaneous/Error.vue'),
  //   meta: {
  //          requiresAuth: false,
  //     layout: 'full',
  //   },
  // },
  {
    path: '/account-setting',
    name: 'account-setting',
    component: () => import('@/views/pages/account-setting/AccountSetting.vue'),
    meta: {
           requiresAuth: false,
      pageTitle: 'Account Settings',
      breadcrumb: [
        {
          text: 'Account Settings',
          active: true,
        },
      ],
    },
  },
]
