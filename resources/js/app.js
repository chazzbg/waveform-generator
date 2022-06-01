import './bootstrap';
import {createApp} from 'vue'
import {createStore} from 'vuex'
import App from './components/App'
import {each} from "lodash/collection";

const store = createStore({
    state: {
        user: null,
        customer: null,
        longest_user_monologue: null,
        longest_customer_monologue: null,
        user_talk_percentage: null
    },
    getters: {
        user: state => state.user,
        customer: state => state.customer,
        longest_user_monologue: state => state.longest_user_monologue,
        longest_customer_monologue: state => state.longest_customer_monologue,
        user_talk_percentage: state => state.user_talk_percentage,
    },
    mutations: {
        user: (state, value) => state.user = value,
        customer: (state, value) => state.customer = value,
        longest_user_monologue: (state, value) => state.longest_user_monologue = value,
        longest_customer_monologue: (state, value) => state.longest_customer_monologue = value,
        user_talk_percentage: (state, value) => state.user_talk_percentage = value,
    },
    actions: {
        loadData: context => {
            axios.get('/api/data').then(result => {
                each(result.data, (v, k) => {
                    context.commit(k, v);
                })
            })
        }
    }
})
const app = createApp(App);
app.use(store)
app.mount('#app')
