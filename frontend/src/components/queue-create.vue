<template>
  <v-row justify="center">
    <v-dialog transition v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Növbə Yarat</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-text-field readonly label="Activity" :value="activity.name"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Qiymət" v-model="queue.detail.price"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-text-field label="Time (with minute)" v-model="queue.detail.period" required></v-text-field>
              </v-col>
              <v-col cols="12" md="12">
                <v-textarea rows="2" label="Description" v-model="queue.detail.description" required></v-textarea>
              </v-col>

            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :disabled="loading" color="blue darken-1" text @click="$emit('close')">
            Close
          </v-btn>
          <v-btn :loading="loading" color="blue darken-1" text @click="store">
            Yarat
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import {queues} from "@/utils/routes";

export default {
  name: "queue-create",
  props:['activity','open'],
  data:() => ({
    dialog:false,
    loading:false,
    queue: {
      queueable_type:null,
      queueable_id:null,
      detail:{
        price:null,
        period:null,
        description:''
      },
    }
  }),
  mounted() {
    this.reload()
  },
  methods:{
    reload() {
      this.queue.queueable_type = this.activity?.model_type;
      this.queue.queueable_id = this.activity?.id;
      this.queue.detail.price = this.activity?.detail?.period_price;
      this.queue.detail.period = this.activity?.detail?.period;
    },
    async store() {
      this.loading = true;
      let response = await this.$http.post(queues,this.queue)
      this.loading = false;

      if (response?.success) {
        this.$toast.success('Queue created successfully');
        this.$emit('success',response?.data)
        this.$emit('close')
      } else {
        this.$toast.error(`Queue doesn't created (${response?.message})`)
      }
    }
  },
  watch:{
    open(value) {
      this.dialog = value;
      this.reload()
    }
  }
}
</script>