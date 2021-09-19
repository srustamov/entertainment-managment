<template>
  <v-container>
    <v-row v-if="!loading">
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

export default {
  name: 'Home',

  components: {
  },
  data:() => ({
    loading:true,
    query: {

    },
    data:{
      queues:[],
      minutes:null,
      amount:null,
    }
  }),
  mounted() {
    this.getData()
  },
  methods:{
    async getData() {
      this.loading = true;
      let response = await this.$http.get('dashboard',{
        params: {...useFilters(this.query)}
      })

      if (response?.success) {
        this.data = response.data;
      }

      this.loading = false;


    }
  }
}
</script>