<template>
    <div class="card shadow">
        <div class="card-header text-center">
            Statistics
        </div>
        <div class="card-body bg-light">
            <div class="vstack gap-2">
                <div class="bg-white border rounded py-2 px-3" :class="{'good' : goodUserTalk, 'medicore': !goodUserTalk}">
                    User Talk Percentage
                    <p class="m-0 float-end">{{ user_talk_percentage }}%</p>
                </div>
                <div class="bg-white border rounded py-2 px-3" :class="{'good' : goodUserMonologue, 'medicore': !goodUserMonologue}">
                    Longest user monologue
                    <p class="m-0 float-end">{{ longest_user_monologue }}s</p>
                </div>
                <div class="bg-white border rounded py-2 px-3" :class="{'good' : goodCustomerMonologue, 'medicore': !goodCustomerMonologue}">
                    Longest customer monologue
                    <p class="m-0 float-end">{{ longest_customer_monologue }}s</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "StatsWidget",
    computed: {
        ...mapGetters([
            'longest_customer_monologue',
            'longest_user_monologue',
            'user_talk_percentage'
        ]),
        goodUserTalk: function () {
            return this.user_talk_percentage & this.user_talk_percentage > 50;
        },
        goodUserMonologue: function () {
            return this.longest_user_monologue && this.longest_user_monologue < 60;
        },
        goodCustomerMonologue: function () {
            return this.longest_customer_monologue && this.longest_customer_monologue > 60;
        },
    }
}
</script>

<style scoped>
    .good {
        color: #008c57
    }
    .medicore {
        color: #ff5800
    }
</style>
