<template>

</template>

<script>
 import {mapGetters} from "vuex";

  export default {
    name: 'Home',
    data:() => ({

    }),
    async mounted() {
      await this.$store.dispatch('queue/fetch')
    },
    components: {
      ...mapGetters({
        queues: 'queue/list'
      })
    },
  }
</script>
