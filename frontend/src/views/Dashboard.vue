<template>
  <v-container>
    <v-row v-if="!loading">

      <v-col cols="12" md="12">
        <v-menu
            ref="menu"
            v-model="dateRangeDialog"
            :close-on-content-click="false"
            :return-value.sync="date"
            transition="scale-transition"
            offset-y
            min-width="auto">
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
                style="max-width: 400px"
                v-model="date"
                label="Picker in menu"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"

            >
              <template v-slot:append>
                <v-btn @click="getData" fab icon color="primary"><v-icon>mdi-reload</v-icon></v-btn>
              </template>
            </v-text-field>

          </template>
          <v-date-picker range v-model="date" no-title scrollable>
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="dateRangeDialog = false">
              Cancel
            </v-btn>
            <v-btn text color="primary" @click="$refs.menu.save(date)">
              OK
            </v-btn>
          </v-date-picker>
        </v-menu>
      </v-col>

      <v-col cols="12" md="6">
        <v-card dark color="primary">
          <v-card-title class="text-h5">Məbləğ</v-card-title>
          <v-card-text>
            <v-btn>{{data.amount}} AZN</v-btn>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <v-card dark color="purple">
          <v-card-title class="text-h5">Ümumi Vaxt</v-card-title>
          <v-card-text>
            <v-btn>{{data.minutes}}</v-btn>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="12">
        <v-card dark>
          <v-card-title class="d-block text-center">Növbələr</v-card-title>
          <v-card-text  v-for="queue in data.queues">
            <v-card-subtitle>{{queue.name}}</v-card-subtitle>
            <v-progress-linear striped :title="queue.name" top :color="queue.color" :value="queue.percent" height="20">
              <strong>{{ Math.ceil(queue.count) }}</strong>
            </v-progress-linear>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else class="fill-height align-center justify-center">
      <v-progress-circular
          :size="70"
          :width="7"
          color="purple"
          indeterminate
      ></v-progress-circular>
    </v-row>
  </v-container>

</template>

<script>
import {useFilters} from "../utils/hooks";
import moment from "moment";

export default {
  name: 'Home',
  data:() => ({
    loading:true,
    date: [],
    dateRangeDialog:false,
    query: {

    },
    data:{
      queues:[],
      minutes:null,
      amount:null,
    }
  }),
  mounted() {
    this.date = []
    this.getData()
  },
  methods:{
    async getData() {
      this.loading = true;
      let response = await this.$http.get('dashboard',{
        params: {date:this.date,...useFilters(this.query)}
      })

      if (response?.success) {
        this.data = response.data;
      }

      this.loading = false;

    }
  }
}
</script>
<style scoped>
.vdpr-datepicker::v-deep .my_custom_class {
  background-color: aqua !important;
}
</style>