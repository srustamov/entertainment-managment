<template>
  <v-navigation-drawer v-model="drawer" dark floating app>
    <v-list elevation="12" nav>
      <v-list-item-group v-model="listModel">
        <v-list-item :value="item.route" :key="item.route" v-for="item in list">
          <v-list-item-icon>
            <v-icon v-html="`fa-${item.icon}`"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{item.name}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>

    <template v-slot:append>
      <div class="pa-2">
        <v-btn :loading="loading" @click="logout" block>
          Logout
        </v-btn>
      </div>
    </template>
  </v-navigation-drawer>
</template>

<script>

import {logout} from '../utils/auth'

export default {
  props:{
    drawer:{
      default:false,
      type:Boolean
    }
  },
  data:() => ({
    loading:false,
    listModel:null,
    list:[
      {
        name : "Əsas",
        icon:'home',
        route:'dashboard'
      },
      {
        name : "Növbələr",
        icon:'user-clock',
        route:'queues'
      }
    ]
  }),
  mounted() {
    this.listModel = this.$route.name;
  },
  methods:{
    async logout() {
      this.loading = true;
      await logout()
      this.loading = false;
    }
  },
  watch:{
    listModel (v) {
      if (this.$route.name !== v) {
        this.$router.push({name:v})
      }
    }
  }
}
</script>