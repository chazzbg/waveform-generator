<template>
<div class="container-fluid">
    <div class="row vh-100 align-items-center align-items-stretch">
        <div class="col-8">
            <waveform-widget />
        </div>
        <div class="col-4">
            <stats-widget />
        </div>
    </div>
</div>
</template>

<script>
import WaveformWidget from "./WaveformWidget";
import StatsWidget from "./StatsWidget";
export default {
    name: "App",
    components: {StatsWidget, WaveformWidget},
    mounted() {
        this.$store.dispatch('loadData')
    }
}
</script>

