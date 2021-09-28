<template>
  <v-data-table
      dense
      v-if="fetchQueuesIsEnable"
      :options.sync="filters"
      :headers="mapHeaders"
      :items="queues.data"
      disable-pagination
      hide-default-footer
      single-expand
      :items-per-page="15"
      :search="search"
      show-expand
      :loading="loading">
    <template v-slot:top>
      <v-row class="flex-wrap">
        <v-col cols="12" xs="12" sm="12" md="3">
          <v-text-field dense solo v-model="search" placeholder="axtar"></v-text-field>
        </v-col>
        <v-col cols="12" xs="12" sm="12" md="6">
          <v-select
              dense
              v-model="query.status_id"
              :items="statuses"
              item-text="name"
              item-value="id"
              solo
              label="Növbə vəziyyəti"
              multiple>
          </v-select>
        </v-col>
        <v-col cols="12" xs="12" sm="6" md="3" class="text-right">
          <v-btn
              small
              class="mr-1"
              v-if="createActive"
              @click="createDialog=true"
              color="success" fab>
            <v-icon>mdi-plus</v-icon>
          </v-btn>
          <v-btn :loading="loading" small @click="fetchQueues(1)" color="primary" fab>
            <v-icon>mdi-reload</v-icon>
          </v-btn>
          <v-menu :close-on-content-click="false" :nudge-width="200" offset-x>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon color="indigo" dark v-bind="attrs" v-on="on">
                <v-icon>mdi-table-headers-eye</v-icon>
              </v-btn>
            </template>

            <v-card>
              <v-card-text>
                <v-checkbox v-model="columns" :label="head.text" color="red" :value="head.text" hide-details
                            v-for="head in getTableHeaders()">
                </v-checkbox>
              </v-card-text>
            </v-card>

          </v-menu>
        </v-col>
      </v-row>
    </template>
    <template v-slot:footer>
      <v-col cols="12" xs="12" class="text-right">
        <v-pagination v-if="queues && queues.total" v-model="query.page" :length="queues.last_page"
                      circle
                      total-visible="7"
                      next-icon="mdi-menu-right"
                      prev-icon="mdi-menu-left">
        </v-pagination>
      </v-col>
    </template>
    <template v-slot:item.actions="{ item,index }">
      <v-btn x-small dark @click="startQueue(item,index)" v-if="item.startable" color="green">
        <v-icon>mdi-play</v-icon>
        Başlat
      </v-btn>
      <v-btn x-small dark @click="endQueue(item,index)" v-if="item.endable" color="red">
        <v-icon>mdi-stop</v-icon>
        Bitir
      </v-btn>
      <v-btn :loading="loading" x-small dark @click="deleteQueue(item,index)" v-if="item.deletable" color="red">
        <v-icon>mdi-remove</v-icon>
        Sil
      </v-btn>
    </template>
    <template v-slot:item.number="{ item }">
      <v-btn x-small dark color="pink">{{ item.number }}</v-btn>
    </template>
    <template v-slot:item.time="{ item }">
      <v-btn depressed x-small color="error" v-if="item.is_expired">Vaxt bitib</v-btn>
      <queue-time v-else-if="item.started_at" :queue="item"></queue-time>
    </template>
    <template v-slot:item.type="{ item }">
      {{ item.queueable.name }}
    </template>
    <template v-slot:item.status_id="{ item }">
      <v-btn text :color="item.status.color">{{ item.status.name }}</v-btn>
    </template>

    <template v-slot:expanded-item="{ headers ,item,index }">
      <td :colspan="headers.length" class="pa-1" style="border:3px solid #546e7a;border-top: 0">
        <v-card elevation="24">
          <v-card-text>
            <v-row>
              <v-col cols="12" md="2">
                <v-text-field flat :readonly="!item.editable" label="Qiymət"
                              v-model="item.detail.price"></v-text-field>
              </v-col>
              <v-col cols="12" md="2">
                <v-text-field :readonly="!item.editable" label="vaxt" v-model="item.detail.period"></v-text-field>
              </v-col>
              <v-col cols="12" md="5">
                <v-textarea rows="1" :readonly="!item.editable" v-model="item.detail.description" flat
                            label="Məlumat"></v-textarea>
              </v-col>
              <v-col cols="12" md="3">
                <v-btn :disabled="!item.editable" :loading="loading" color="info"
                       @click="updateQueueDetail(item,index)">Yenilə
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </td>
    </template>

  </v-data-table>
</template>

<script>
export default {
  name: "queue-table",
  props:{
    loading : {
      type : Boolean,
      default:false
    },
    queues:{
      required: true,
      type: Object,
      default : {
        data : []
      }
    },
    filters:{
      default : {}
    }
  }
}
</script>

<style scoped>

</style>