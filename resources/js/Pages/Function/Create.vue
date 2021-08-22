<template>
  <Head :title="__('messages.databases') + ' > ' + __('messages.create')" />

  <App
    :breadcrumbs="[
      { label: __('messages.databases'), to: '/database' },
      { label: __('messages.create') },
    ]"
  >
    <Form :form="form" :types="types" @submit="submit" />
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link, useRemember } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Form from "./Form.vue";

export default {
  components: {
    App,
    Head,
    Link,
    Form,
  },
  props: {
    types: Array,
  },
  setup(props) {
    const form = useRemember({
      name: "",
      type: "",
      host: "",
      port: "",
      db: "",
      schema: "",
      username: "",
      password: "",
    });
    function submit() {
      Inertia.post(route("database.store"), form);
    }

    return { form, submit };
  },
};
</script>