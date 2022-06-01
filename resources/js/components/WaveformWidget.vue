<template>
    <div class="card shadow">
        <div class="card-header border-0 text-center">
            Waveform
        </div>
        <div class="card-body bg-light">
            <div class="row mb-5">
                <div class="col-1">
                    User
                </div>
                <div class="col-11 d-flex flex-row justify-content-start ">
                    <div v-for="(size,k) in userSizings" :key="k" :style="'width: '+size.size+'%'" :class="{'user': size.status === 'talk'}"
                    class="rounded-2"
                    ></div>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    Customer
                </div>
                <div class="col-11 d-flex flex-row justify-content-start">
                    <div v-for="(size,k) in customerSizings" :key="k" :style="'width: '+size.size+'%'" :class="{'customer': size.status === 'talk'}"
                         class="rounded-2"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import {each} from "lodash/collection";

export default {
    name: "WaveformWidget",
    computed: {
        ...mapGetters([
            'user',
            'customer',
        ]),
        totalTalkTime: function (){
            let userLastTime = this.user[this.user.length -1][1];
            let customerLastTime = this.customer[this.customer.length -1][1];

            return Math.max(userLastTime, customerLastTime);
        },
        userTimings: function (){
            return this.calculateTimings(this.user);
        },
        userSizings: function (){
            let that = this;
            return this.userTimings.map(function (v) {
                v.size = (v.time / that.totalTalkTime) * 100
                return v;
            });
        },
        customerTimings: function (){
            return this.calculateTimings(this.customer)
        },
        customerSizings: function (){
            let that = this;
            return this.customerTimings.map(function (v) {

                v.size = (v.time / that.totalTalkTime) * 100
                return v;
            });
        },
    },
    methods: {
        calculateTimings: function (monologue) {
            let timings = [];
            let previous = null;
            each(monologue, segment => {
                const [start, end] = segment;

                if(previous){
                    timings.push({
                        status: 'silent',
                        time: start - previous[1]
                    });
                }

                timings.push({
                    status: 'talk',
                    time: end - start,
                });


                previous = segment;
            })

            return timings;
        }
    }
}
</script>

<style scoped>
.user {
    height: 48px;
    background: rgb(175,118,2);
    background: linear-gradient(90deg, rgba(175,118,2,1) 0%, rgba(252,198,89,1) 100%);
}
.customer {
    height: 48px;
    background: rgb(103,162,142);
    background: linear-gradient(90deg, rgba(103,162,142,1) 0%, rgba(179,208,199,1) 100%);
}
</style>
