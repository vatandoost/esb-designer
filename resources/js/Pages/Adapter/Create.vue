<template>
  <Head :title="__('messages.adapters') + ' > ' + __('messages.create')" />

  <App
    :breadcrumbs="[
      { label: __('messages.adapters'), to: route('adapter.index') },
      { label: __('messages.create') },
    ]"
  >
    <Form :form="form" :funcs="funcs" :types="types" @submit="submit" />
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
    funcs: Array,
  },
  setup(props) {
    const form = useRemember({
      name: "",
      type: "",
      function_id: "",
      function_config: { input_params: {}, output_params: {} },
    });
    function submit(data) {
      Inertia.post(route("adapter.store"), data);
    }

    return { form, submit };
  },
};
</script>