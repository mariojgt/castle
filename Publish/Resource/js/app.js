// Load vue js
import { createApp } from 'vue/dist/vue.esm-bundler';

import naive from "naive-ui";
import VueTailwind from 'vue-tailwind'

const el = document.getElementById("app");

const app = createApp({}).use(naive);

import FlashMessage from "./vueComponents/utility/FlashMessage.vue";
// Reusable
app.component("flashMessage", FlashMessage);

app.mount(el);
