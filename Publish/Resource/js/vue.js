// Load vue js
import { createApp, h } from "vue";

import naive from "naive-ui";

const el = document.getElementById("app");

const app = createApp({}).use(naive);

import FlashMessage from "./vue_components/FlashMessage.vue";
// Reusable
app.component("flashMessage", FlashMessage);

app.mount(el);
