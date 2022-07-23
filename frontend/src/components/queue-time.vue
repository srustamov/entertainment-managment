<template>
  <v-btn text>{{ hour }}:{{ minutes }}:{{ seconds }}</v-btn>
</template>

<script>
import moment from 'moment'
import {mapGetters} from "vuex";
import {ACTIVITY_ITEM_TYPE, ACTIVITY_TYPE} from "@/utils/queue";

export default {
  props: ['queue'],
  data() {
    return {
      timer: null,
      now: moment().unix(),
      endDate: null,
      sound: new Audio('sounds/notification.mp3')
    }
  },
  async mounted() {

    this.timer = await this.$store.getters['queue/timers'][`timer-${this.queue.id}`];

    this.start()
  },
  computed: {
    ...mapGetters({
      timers: 'queue/timers'
    }),
    hour() {
      let hours = Math.trunc((this.endDate - this.now) / 3600);
      return hours > 9 ? hours : '0' + (hours < 0 ? "0" : hours);
    },
    minutes() {
      let minutes = Math.trunc((this.endDate - this.now) / 60) % 60;
      return minutes > 9 ? minutes : '0' + (minutes < 0 ? 0 : minutes);
    },
    seconds() {
      let seconds = Math.trunc((this.endDate - this.now)) % 60
      return seconds > 9 ? seconds : '0' + (seconds < 0 ? "0" : seconds);
    }
  },
  methods: {
    start() {
      if (this?.queue?.started_at) {
        this.endDate = moment(this.queue.started_at).add(this.queue?.detail?.period, 'minutes').unix()
      }
    },
  },
  watch: {
    endDate: {
      //immediate: true,
      async handler(newVal) {

        if (this.timer) {

          clearInterval(this.timer);

          await this.$store.dispatch('queue/clearTimer', this.queue.id)
        }

        if (this.queue.status_id !== 2) {
          return;
        }

        let interval = setInterval(async () => {
          this.now = moment().unix()
          if (this.now > newVal) {
            this.now = newVal
            clearInterval(this.$store.getters['queue/timers'][`timer-${this.queue.id}`])
            await this.$store.dispatch('queue/clearTimer', this.queue.id)
            this.queue.is_expired = true;
            this.$toast.default(`${this.queue.number} sıralı ${this.queue.queueable.name} növbəsi bitdi`, {
              duration: 7000,
              dismissible: true,
              pauseOnHover: true,
              onClick: () => {
                if (this.$route.name !== 'queues') {

                  let isBaseActivity = this.queue.queueable_type === ACTIVITY_TYPE;

                  this.$router.push({
                    name: "queues", query: {
                      activity: isBaseActivity ? this.queue.queueable_id : this.queue?.queueable?.activity_id,
                      activity_item: isBaseActivity ? undefined :  this.queue.queueable_id,
                      queue:this.queue.id
                    }
                  })
                }
              }
            })
            await this.sound.play()
          }
        }, 1000)

        await this.$store.dispatch('queue/setTimer', {
          key: this.queue.id,
          timer: interval
        })
      }
    },
    queue: {
      handler() {

      },
      deep: true
    }
  },
  beforeDestroy() {
    //clearInterval(this.timer)
  }
}
</script>