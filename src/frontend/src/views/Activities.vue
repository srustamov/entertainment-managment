<template>
  <v-card>

  </v-card>
</template>

<script>
import {mapGetters} from "vuex";
export default {
  name: 'Activities',
  components: {
  },
  data:() => ({

  }),
  computed:{
    ...mapGetters({
      activities:'activity/list'
    })
  },
  mounted() {
    this.$store.dispatch('activity/fetch')
  }
}
</script>