import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';
import en from 'vuetify/lib/locale/en'
Vue.use(Vuetify);

export default new Vuetify({
    lang: {
        locales: { en },
        current: 'en',
    },
    theme: {
        primary: "#f44336",
        secondary: "#e57373",
        accent: "#9c27b0",
        error: "#f44336",
        warning: "#ffeb3b",
        info: "#2196f3",
        success: "#4caf50"
    },
    icons: {
        iconfont: 'fa'
    },
});
