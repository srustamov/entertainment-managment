<template>
  <v-btn text>{{ hour }}:{{ minutes }}:{{ seconds }}</v-btn>
</template>

<script>
import moment from 'moment'
import {mapGetters} from "vuex";

export default {
  props: ['queue'],
  data() {
    return {
      timer : null,
      now: moment().unix(),
      endDate: null,
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

        let interval = setInterval(() => {
          this.now = moment().unix()
          if (this.now > newVal) {
            this.now = newVal
            clearInterval(this.$store.getters['queue/timers'][`timer-${this.queue.id}`])
            this.$store.dispatch('queue/clearTimer',this.queue.id)
            this.queue.is_expired = true;
            this.$toast.default(`${this.queue.number} sıralı ${this.queue.queueable.name} növbəsi bitdi`, {
              duration: 7000,
              dismissible: true,
              pauseOnHover: true
            })
            let sound = new Audio('sounds/notification.mp3');
            sound.play()
          }
        }, 500)

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