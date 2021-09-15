<template>
  <el-container v-if="isAuthenticated" id="app" style="margin: 0;padding: 0;">
    <el-aside  width="300px" style="background-color: rgb(238, 241, 246)">
      <el-menu router collapse-transition>
        <el-menu-item index="1">Option 4-1</el-menu-item>
        <el-menu-item index="2">Option 4-1</el-menu-item>
        <el-submenu index="1-4">
          <template slot="title">Option4</template>
          <el-menu-item index="1-4-1">Option 4-1</el-menu-item>
        </el-submenu>
      </el-menu>
    </el-aside>
    <el-container>
      <el-header  style="text-align: right; font-size: 12px">
        <el-dropdown>
          <i class="el-icon-setting" style="margin-right: 15px"></i>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item>View</el-dropdown-item>
            <el-dropdown-item>Add</el-dropdown-item>
            <el-dropdown-item>Delete</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
        <span>Tom</span>
      </el-header>

      <el-main>
        <router-view></router-view>
      </el-main>
    </el-container>
  </el-container>
  <el-container v-else-if="!loading" id="app" style="margin: 0;padding: 0;">
    <router-view></router-view>
  </el-container>
</template>



<script>
import {mapGetters} from "vuex";

export default {
  data: () => ({
    loading:true
  }),
  mounted() {
    setTimeout(() => this.loading = false,200)
  },
  computed:{
    ...mapGetters([
        'isAuthenticated'
    ])
  }
};
</script>

<style>
.el-header {
  background-color: #B3C0D1;
  color: #333;
  line-height: 60px;
}

.el-aside {
  color: #333;
}
</style>