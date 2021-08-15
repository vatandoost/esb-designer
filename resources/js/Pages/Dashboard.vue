<template>
  <Head title="Dashboard" />

  <App>
    Hello {{ $page.props.auth.user.name.toUpperCase() }}, Welcome
    <Button label="Hello" class="p-m-10" />
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
};
</script>
