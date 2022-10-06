// import vue
import Vue from 'vue';
// import i18n
import VueI18n from 'vue-i18n';

// en
import enLangAuth from './en/auth'
import enLangCommon from  './en/common'

// vi
import viLangAuth from './vi/auth'
import viLangCommon from  './vi/common'

Vue.use(VueI18n);


const langLocals = {
    en: {
        common: enLangCommon,
        auth: enLangAuth
    },
    vi: {
        common: viLangCommon,
        auth: viLangAuth
    }
}

export default new VueI18n({
    locale: 'en',
    fallbackLocale: 'en',
    messages: langLocals,
});
