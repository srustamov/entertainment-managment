import VueI18n from 'vue-i18n'

import Vue from 'vue';

Vue.use(VueI18n)

async function getLocaleDataFromServer () {
    return await fetch(`${process.env.VUE_APP_API_URL}/lang.json`).then(r => r.json());
}

async function useI18n() {

    const {locale,messages} = await getLocaleDataFromServer();

    return new VueI18n({
        locale: locale,
        fallbackLocale:'en',
        messages: messages
    })
}

export default useI18n;