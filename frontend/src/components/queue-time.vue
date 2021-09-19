<template>
  <v-btn text>{{ hour }}:{{ minutes }}:{{ seconds }} ({{queue.queueable.detail.period}} dəq) </v-btn>
</template>

<script>
import moment from 'moment'

export default {
  props: ['queue'],
  data() {
    return {
      now: moment().unix(),
      timer: null,
      endDate: null,
    }
  },
  mounted() {
    if (this?.queue?.started_at) {
      this.endDate = moment(this.queue.started_at).add(this.queue?.queueable?.detail?.period,'minutes').unix()

    }
  },
  computed: {
    hour() {
      let hours = Math.trunc((this.endDate - this.now)  / 3600);
      return hours > 9 ? hours : '0' + hours;
    },
    minutes() {
      let minutes = Math.trunc((this.endDate - this.now)  / 60) % 60;
      return minutes > 9 ? minutes : '0' + minutes;
    },
    seconds() {
      let seconds = Math.trunc((this.endDate - this.now) ) % 60
      return seconds > 9 ? seconds : '0' + seconds;
    }
  },
  watch: {
    endDate: {
      immediate: true,
      handler(newVal) {
        if (this.timer) {
          clearInterval(this.timer)
        }

        if(moment().unix() > newVal) {
          //console.log(moment().unix(),newVal)
          //return this.queue.is_expired = true;
        }

        this.timer = setInterval(() => {
          this.now = moment().unix()
          if (this.now > newVal) {
            this.now = newVal
            clearInterval(this.timer)
            this.queue.is_expired = true;
            this.$toast.default(`${this.queue.number} sıralı ${this.queue.queueable.name} növbəsi bitdi`,{
              duration:5000,
              dismissible:true,
              pauseOnHover:true
            })
            let sound = new Audio('sounds/notification.mp3');
            sound.play()
          }
        }, 1000)
      }
    }
  },
  beforeDestroy() {
    //clearInterval(this.timer)
  }
}
</script>