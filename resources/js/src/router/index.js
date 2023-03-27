import Vue from 'vue'
import VueRouter from 'vue-router'

// Routes
import {canNavigate} from '@/libs/acl/routeProtection'
import {isUserLoggedIn, getUserData, getHomeRouteForLoggedInUser} from '@/auth/utils'
import apps from './routes/apps'
import dashboard from './routes/dashboard'
import pages from './routes/pages'
// import uiElements from './routes/ui-elements/index'
// import chartsMaps from './routes/charts-maps'
// import formsTable from './routes/forms-tables'
// import others from './routes/others'
import partners from './routes/partners'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior() {
        return {x: 0, y: 0}
    },
    routes: [
        {
            path: '/', redirect: {name: 'admin-dashboard-leads-uk',}
        },
        ...apps,
        ...dashboard,
        ...pages,
        ...partners,
        // ...chartsMaps,
        // ...formsTable,
        // ...uiElements,
        // ...others,
        {
            path: '*',
            redirect: 'auth-login',
        },
    ],
})


router.beforeEach((to, _, next) => {
//     const isLoggedIn = isUserLoggedIn()
//
//     if (!canNavigate(to)) {
//         // Redirect to login if not logged in
//         if (!isLoggedIn) return next({name: 'auth-login'})
//         const userData = getUserData()
//
//         // If logged in => not authorized
//         return next(getHomeRouteForLoggedInUser(userData ? userData.is_admin : null))
//
//     }
//
//     // Redirect if logged in
//     if (to.meta.requiresAuth && isLoggedIn) {
//         const userData = getUserData()
//
//         if (to.meta.adminAuth && userData.is_admin == 1) {
//             console.log('ADMIN')
//             // debugger
//             next()
//         }  if (to.meta.partnerAuth && userData.is_admin == 0) {
//             console.log('PARTNER')
//             // debugger
//             next()
//         }
//         // {
//         //         return next({name: 'auth-login'})
//         //     }
//     }
    return next()
})


// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = 'none'
    }
})

export default router
