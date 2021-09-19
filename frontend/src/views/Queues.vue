<template>
  <v-card>

    <v-card-subtitle class="text-center d-block">Fəaliyyətlər</v-card-subtitle>

    <v-card-title>
      <v-card style="width: 100%" dark elevation="24">
        <v-tabs v-model="activityTabModel" background-color="deep-purple accent-4" flat centered dark>
          <v-tab v-for="activity in activities" @click="selectActivity(activity)" :key="`${activity.model_type}:${activity.id}`">
            {{ activity.name }}
          </v-tab>
        </v-tabs>
      </v-card>
    </v-card-title>


    <v-card-title v-if="selectedActivity && selectedActivity.items && selectedActivity.items.length">
      <v-card style="width: 100%;text-align: center" dark elevation="24">
        <v-btn-toggle v-model="activityItemTabModel" color="success">
          <v-btn class="ma-1" elevation="12" @click="selectActivityItem(item)" dark :value="item.id" v-for="item in selectedActivity.items">
            {{ item.name }}
          </v-btn>
        </v-btn-toggle>
      </v-card>
    </v-card-title>

    <v-card-text>
      <v-data-table
          v-if="fetchQueuesIsEnable"
          :options.sync="filters"
          :headers="headers"
          :items="queues.data"
          disable-pagination
          :items-per-page="15"
          show-expand
          :loading="loading">
        <template v-slot:top>
          <v-row class="flex-wrap">
            <v-col cols="12" xs="12" sm="6" md="2">
              <v-select
                  v-model="query.status_id"
                  :items="statuses"
                  attach
                  item-text="name"
                  item-value="id"
                  chips
                  label="Növbə vəziyyəti"
                  multiple>
              </v-select>
            </v-col>

            <v-col cols="12" xs="12" sm="6" md="8" class="text-right">
              <v-pagination v-if="queues && queues.total" v-model="query.page" :length="queues.last_page"
                  circle
                  total-visible="7"
                  next-icon="mdi-menu-right"
                  prev-icon="mdi-menu-left">
              </v-pagination>
            </v-col>
            <v-col cols="12" xs="12" sm="6" md="2" class="text-right">
              <v-btn
                  class="mr-1"
                  v-if="createActive"
                  @click="createDialog=true"
                  color="success" fab>
                <v-icon>mdi-plus</v-icon>
              </v-btn>
              <v-btn :loading="loading" small @click="fetchQueues(1)" color="primary" fab>
                <v-icon>mdi-reload</v-icon>
              </v-btn>
            </v-col>

          </v-row>
        </template>
        <template v-slot:item.actions="{ item,index }">
          <v-btn small dark  @click="startQueue(item,index)" v-if="item.startable" color="green">
            <v-icon>mdi-play</v-icon> Başlat
          </v-btn>
          <v-btn small dark  @click="endQueue(item,index)" v-if="item.endable" color="red">
            <v-icon>mdi-stop</v-icon> Bitir
          </v-btn>
          <v-btn :loading="loading" small dark @click="deleteQueue(item,index)" v-if="item.deletable" color="red">
            <v-icon>mdi-remove</v-icon> Sil
          </v-btn>
        </template>
        <template v-slot:item.number="{ item }">
          <v-btn fab small dark color="pink">{{item.number}}</v-btn>
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
                    <v-text-field flat :readonly="!item.editable" label="Qiymət" v-model="item.detail.price"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="2">
                    <v-text-field :readonly="!item.editable" label="vaxt" v-model="item.detail.period"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="5">
                    <v-textarea rows="1" :readonly="!item.editable" v-model="item.detail.description" flat label="Məlumat"></v-textarea>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-btn :disabled="!item.editable" :loading="loading" color="info" @click="updateQueueDetail(item,index)">Yenilə</v-btn>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </td>
        </template>

      </v-data-table>
    </v-card-text>

    <queue-create-dialog
        v-if="createActive"
        @close="createDialog = false"
        :open="createDialog"
        @success="queue => this.queues.data.unshift(queue)"
        :activity="selectedActivityItem || selectedActivity">
    </queue-create-dialog>
  </v-card>
</template>

<script>
import {mapGetters} from "vuex";
import {useFilters} from "../utils/hooks";
import QueueTime from '../components/queue-time';
import QueueCreateDialog from '../components/queue-create';
import QueueService from "../services/QueueService";

export default {
  name: 'Home',
  components: {
    QueueTime,QueueCreateDialog
  },
  data: () => ({
    loading: true,
    search: '',
    headers: [
      {text: 'Növbə', value: 'number'},
      {text: 'Tip', value: "type", sortable: false},
      {text: 'Qalan Vaxt', value: "time", sortable: false},
      {text: 'Status', value: "status_id", sortable: true},
      {text: 'Başlama tarixi', value: 'started_at', sortable: true},
      {text: 'Yaradılma tarixi', value: 'created_at'},
      {text: 'Bitmə tarixi', value: 'end_at', sortable: true},
      {text: 'Əməliyyatlar', value: 'actions', sortable: false, align: 'center'},
    ],
    filters: {},
    query: {
      page: 1,
      with: ['queueable'],
    },
    activityTabModel: null,
    activityItemTabModel: null,
    selectedActivity: null,
    selectedActivityItem: null,
    createDialog:false
  }),
  async mounted() {
    await this.fetchActivities()
    this.activityTabModel = 0;

    if (this.activities.length) {
      this.selectActivity(this.activities[0])
    }

    await this.$store.dispatch('queue/fetchStatuses');
  },
  computed: {
    ...mapGetters({
      queues: 'queue/list',
      statuses: 'queue/statuses',
      activities: 'activity/list',
    }),
    fetchQueuesIsEnable() {
      if (this.selectedActivityItem) {
        return true;
      }
      return this.selectedActivity && (
          this.selectedActivity?.detail || this.selectedActivity?.items?.length
      );
    },
    createActive() {
      return this.selectedActivityItem?.detail ||  this.selectedActivity?.detail;
    }
  },
  methods: {
    async fetchQueues(page) {
      if (!this.fetchQueuesIsEnable) {
        return false;
      }

      this.loading = true;

      await this.$store.dispatch('queue/fetch', {
        page, ...useFilters(
            {...this.filters, ...this.query}
        )
      })
      this.loading = false;
    },
    async fetchActivities() {
      this.loading = true;
      await this.$store.dispatch('activity/fetch', useFilters({with: ['items']}))
      this.loading = false;
    },
    selectActivity(value) {
      this.selectedActivityItem = null;
      this.activityItemTabModel = null;
      this.selectedActivity = value;
      this.setActivityQuery(value);
    },
    selectActivityItem(value) {
      this.selectedActivityItem = value
      this.setActivityQuery(value);
    },
    setActivityQuery(value) {
      if (value?.detail) {
        this.$set(this.query, 'query', [
          ['queueable_type', value.model_type],
          ['queueable_id', value.id],
        ])
      } else if (value?.items && value.items.length) {
        this.$set(this.query, 'query', [
          ['queueable_type', value.items[0].model_type],
          ['queueable_id', value.items.map(v => v.id)],
        ])
      }
    },
    async startQueue(queue,index) {
      this.loading = true;
      let response = await QueueService.make(queue).start()
      this.loading = false;

      if (response) {
        this.$toast.success('Növbə başladıldı')
        this.$set(this.queues.data,index,response)
      } else {
        this.$toast.error('Növbə başladılmadı')
      }
    },
    async endQueue(queue,index) {
      this.loading = true;
      let response = await QueueService.make(queue).end()
      this.loading = false;

      if (response) {
        this.$toast.success('Növbə bitirildi')
        this.$set(this.queues.data,index,response)
      } else {
        this.$toast.error('Növbə bitirilmədi')
      }
    },
    async updateQueueDetail(queue,index) {
      this.loading = true;
      let response = await QueueService.make(queue).updateDetail()

      if (response) {
        this.$set(this.queues.data,index,response)
      }

      this.loading = false;
    },
    async deleteQueue(queue,index) {
      this.loading = true;
      let response = await QueueService.make(queue).remove()
      this.loading = false;

      if (response) {
        this.queues.data.splice(index,1)
      }

    }
  },
  watch: {
    filters: {
      handler(v,old) {
        if (!_.isEmpty(old)) {
          this.fetchQueues(1)
        }

      },
      deep: true
    },
    query: {
      handler() {
        this.fetchQueues(1)
      },
      deep: true
    },
    activityTabModel(v) {
      console.log(v)
    }
  }
}
</script>
