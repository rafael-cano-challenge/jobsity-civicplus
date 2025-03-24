import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";
//VideoBackground
import VideoBackground from "vue-responsive-video-background-player";
//Sweetalert2
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
//VueDatePicker
import VueDatePicker from "@vuepic/vue-datepicker";
import "./assets/css/custom-vuedatepicker.css";
//Moment
import momentPlugin from "./plugins/moment";
//FloatingVue
import FloatingVue from "floating-vue";
import "floating-vue/dist/style.css";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
// Plugins
app.use(momentPlugin);
app.use(router);

app.use(VueSweetalert2);
app.use(FloatingVue);

// Components
app.component("VideoBackground", VideoBackground);
app.component("VueDatePicker", VueDatePicker);

//Mount
app.mount("#app");

export default app;
