<template>
  <v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="dark">
                <v-toolbar-title>Login form</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form @submit.native.prevent="login" ref="form" :lazy-validation="true">
                  <v-text-field
                      :rules="rules.email"
                      v-model="model.email"
                      required
                      prepend-icon="fa-person"
                      name="login"
                      label="Email"
                      type="text"
                      solo
                  ></v-text-field>
                  <v-text-field
                      :rules="rules.password"
                      required
                      v-model="model.password"
                      prepend-icon="fa-lock"
                      name="password"
                      label="Şifrə"
                      type="password"
                      solo
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="login" type="submit" color="primary">Giriş</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>

import {login} from '../utils/routes';

export default {
  name: "login",
  data() {
    return {
      model: {
        email: "",
        password: ""
      },
      loading: false,
      rules: {
        email: [
          v => !!v || 'Email tələb olunur'
        ],
        password: [
          v => !!v || 'Şifrə tələb olunur'
        ]
      }
    };
  },
  mounted() {
  },
  methods: {
    async login() {
      let valid = await this.$refs.form.validate();
      if (!valid) return;

      this.loading = true;

      const response = await this.$http.post(login,this.model);

      this.loading = false;

      if (response.success) {

        const {user,access_token} = response.data;

        localStorage.setItem('token',access_token)

        await this.$store.dispatch('login',{user,access_token})

        this.$toast.success(response.message || 'Login successfully')

        await this.$router.push({name:'dashboard'})

      } else {
        this.$toast.error(response.message);
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.login {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-button {
  width: 100%;
  margin-top: 40px;
}
.login-form {
  width: 290px;
}
.forgot-password {
  margin-top: 10px;
}
</style>
<style lang="scss">
$teal: rgb(0, 124, 137);
.el-button--primary {
  background: $teal;
  border-color: $teal;

  &:hover,
  &.active,
  &:focus {
    background: lighten($teal, 7);
    border-color: lighten($teal, 7);
  }
}
.login .el-input__inner:hover {
  border-color: $teal;
}
.login .el-input__prefix {
  background: rgb(238, 237, 234);
  left: 0;
  height: calc(100% - 2px);
  left: 1px;
  top: 1px;
  border-radius: 3px;
  .el-input__icon {
    width: 30px;
  }
}
.login .el-input input {
  padding-left: 35px;
}
.login .el-card {
  padding-top: 0;
  padding-bottom: 30px;
}
h2 {
  font-family: "Open Sans";
  letter-spacing: 1px;
  font-family: Roboto, sans-serif;
  padding-bottom: 20px;
}
a {
  color: $teal;
  text-decoration: none;
  &:hover,
  &:active,
  &:focus {
    color: lighten($teal, 7);
  }
}
.login .el-card {
  width: 340px;
  display: flex;
  justify-content: center;
}
</style>
