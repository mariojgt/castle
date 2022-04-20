<template></template>

<script setup>
import { watch, onMounted } from "vue";
import { useMessage } from "naive-ui";

const message = useMessage();

const props = defineProps({
  type: {
    type: String,
    default: "success",
  },
  message: {
    type: String,
    default: "Message here",
  },
});

const startMessage = async () => {
  // If there is any message we can display it
  // Bases on the flash type, show the toast
  switch (props.type) {
    case "success":
      message.success(props.message);
      break;
    case "error":
      message.error(props.message);
      break;
    case "warning":
      message.warning(props.message);
      break;
    case "info":
      message.info(props.message);
      break;
    default:
      message.info(props.message);
      break;
  }
};

onMounted(() => {
  startMessage();
});
</script>
