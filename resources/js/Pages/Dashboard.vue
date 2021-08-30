<template>
  <Head title="Dashboard" />

  <App>
    {{ __("messages.welcome") }}
    <font-awesome-icon icon="user-secret" />
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import Button from "primevue/button";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  components: {
    App,
    Head,
    Button,
  },
  setup(props) {},
};
</script>
