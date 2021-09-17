<template>
  <v-card>
    <v-data-table
        :options.sync="options"
        :headers="headers"
        :items="queues.data"
        :search="search"
        :disable-pagination="true"
        hide-default-footer
        show-expand
        :loading="loading">
      <template v-slot:top>
        <v-row class="flex-wrap">
          <v-col cols="12" xs="12" sm="6" md="3">
            <v-text-field style="max-width: 300px" v-model="search" label="Search" class="mx-4"/>
          </v-col>

          <v-col cols="12" xs="12" sm="6" md="2" class="text-right">
            <v-btn :loading="loading" @click="fetchQueues(1)" color="primary" fab>
              <v-icon>mdi-reload</v-icon>
            </v-btn>
          </v-col>
          <v-col class="d-flex" cols="12" xs="12" sm="12" md="12">
            <div class="form-group m-1">
              <input class="form-control" type="datetime-local">
            </div>
            <div class="form-group m-1">
              <input class="form-control" type="datetime-local">
            </div>
          </v-col>

        </v-row>
      </template>
      <template v-slot:item.actions="{ item }">

        <v-btn small @click="" color="green">
          <v-icon>mdi-back</v-icon> təsdiqlə
        </v-btn>

        <v-btn small @click="" color="purple">
          <v-icon>mdi-cash-refund</v-icon> geri qaytar
        </v-btn>

        <v-btn small  color="green">
          <v-icon>mdi-reload</v-icon> Təkrar cəhd et
        </v-btn>

        <v-btn @click="" color="red">
          <v-icon>mdi-trash</v-icon> sil
        </v-btn>
      </template>
      <template v-slot:item.type="{ item }">
        {{item.queueable.name}}
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
 import {mapGetters} from "vuex";
 import {useFilters} from "../utils/hooks";

  export default {
    name: 'Home',
    data:() => ({
      loading:true,
      search:'',
      options:{},
      headers:[
        {text: 'Növbə', value: 'number'},
        {text: 'Tip', value:"type", sortable: false},
        {text: 'Başlama tarixi', value: 'started_at', sortable: true},
        {text: 'Yaradılma tarixi', value: 'created_at'},
        {text: 'Bitmə tarixi', value: 'end_at', sortable: true},
        {text: 'Əməliyyatlar', value: 'actions', sortable: false, align: 'center'},
      ],
      filters:{
        with:['queueable'],
        sort:{}
      }
    }),
    async mounted() {
      await this.fetchQueues(1)
    },
    computed: {
      ...mapGetters({
        queues: 'queue/list'
      })
    },
    methods:{
      async fetchQueues(page) {
        this.loading = true;
        await this.$store.dispatch('queue/fetch',{page,...useFilters(this.filters)})
        this.loading = false;
      }
    },
    watch:{
      options(v) {
        if (v.sortBy.length) {
          let sort = {};
          sort[v.sortBy[0]] = v.sortDesc[0] ? 'ASC' : 'DESC'
          this.$set(this.filters,`sort`,sort)
          console.log( this.filters)
        }
      },
      filters:{
        handler(){
          this.fetchQueues(1)
        },
        deep:true
      }
    }
  }
</script>
