<template>
  <v-navigation-drawer  v-model="drawer" dark app>
    <v-list elevation="12" nav>
      <v-list-item-group v-model="listModel">
        <v-list-item :disabled="item.disabled" :value="item.route" :key="index" v-for="(item,index) in list">
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
        <v-btn :loading="loading" @click="logout" rounded block>
          <v-icon>mdi-logout</v-icon> {{$t('sidebar.logout')}}
        </v-btn>
      </div>
    </template>
  </v-navigation-drawer>
</template>

<script>

import {logout} from '@/utils/auth'

export default {
  props:{
    drawer:{
      default:false,
      type:Boolean
    }
  },
  data(){
    return {
      loading:false,
      listModel:null,
      list:[
        {
          name : this.$t('sidebar.dashboard'),
          icon:'home',
          route:'dashboard'
        },
        {
          name : this.$t('sidebar.queues'),
          icon:'user-clock',
          route:'queues'
        },
        {
          name : this.$t('sidebar.activities'),
          icon:'sitemap',
          route:'',
          disabled:true
        },
        {
          name : this.$t('sidebar.subscriptions'),
          icon:'clock-outline',
          route:'',
          disabled:true
        },
        {
          name : this.$t('sidebar.settings'),
          icon:'cog',
          route:'',
          disabled:true
        }
      ]
    }
  },
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