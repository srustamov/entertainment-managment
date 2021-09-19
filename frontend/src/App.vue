<template>
  <v-app v-if="!contentLoading && isAuthenticated">
    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

    <sidebar :drawer="drawer"/>

    <v-main class="grey lighten-2">
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>

  <v-app v-else-if="!contentLoading && !isAuthenticated">
    <v-main>
      <router-view/>
    </v-main>
  </v-app>
</template>

<script>
import {mapGetters} from 'vuex'
import sidebar from './components/sidebar'
export default {
  data: () => ({
    contentLoading: false,
    drawer:true
  }),
  components:{
    sidebar
  },
  async mounted() {
  },
  methods: {
  },
  computed: {
    ...mapGetters([
      'isAuthenticated',
    ])
  }
};
</script>