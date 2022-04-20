// Load vue js
import { createApp, h } from "vue";

import flashMessage from "./vue_components/FlashMessage.vue";
import naive from "naive-ui";

const el = document.getElementById("app");

const app = createApp({}).use(naive);

// Reusable
app.component("flashMessage", flashMessage);

app.mount(el);
