import { createApp } from 'vue';
import TelemetryMonitor from './Components/TelemetryMonitor.vue';

const app = createApp({});
app.component('telemetry-monitor', TelemetryMonitor);
app.mount('#app');