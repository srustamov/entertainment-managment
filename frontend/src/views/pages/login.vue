<template>
  <form>
    <v-text-field
        v-model="form.email"
        :counter="10"
        label="Email"
        required
    ></v-text-field>
    <v-text-field
        v-model="form.password"
        label="Password"
        required
    ></v-text-field>


    <v-btn class="mr-4" @click="login">
      submit
    </v-btn>
  </form>
</template>

<script>

import {AUTH_REQUEST} from "../../helpers/auth";

export default {
  data: () => ({
    loading: false,
    form: {
      email: '',
      password: ''
    }
  }),
  mounted() {
  },
  methods: {
    login() {
      this.loading = true;

      this.$store.dispatch(AUTH_REQUEST, this.form)

    }
  }
}
</script>