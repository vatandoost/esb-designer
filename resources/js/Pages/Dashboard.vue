<template>
  <Head title="Dashboard" />

  <App>
    {{ __("messages.welcome") }}
  </App>
</template>

<script>
// import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
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
