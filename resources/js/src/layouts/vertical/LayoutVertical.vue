<template>
  <layout-vertical
      v-if="userData.is_admin === 0"
      :nav-menu-items="navMenuPartnerItems"
  >
    <router-view />
  </layout-vertical>

    <layout-vertical
        v-else-if="userData.is_admin === 1"
        :nav-menu-items="navMenuItems"
    >
        <router-view />
    </layout-vertical>
</template>

<script>
import LayoutVertical from '@core/layouts/layout-vertical/LayoutVertical.vue'
import navMenuItems from '@/navigation/vertical'
import navMenuPartnerItems from '@/navigation/verticalpartner'
import {getUserData} from '@/auth/utils'

export default {
  components: {
    LayoutVertical,
  },
    setup() {
      const userData = getUserData()

        return {
          userData,
            navMenuItems,
            navMenuPartnerItems,
        }
    }
}
</script>
