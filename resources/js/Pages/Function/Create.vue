<template>
  <Head :title="__('messages.databases') + ' > ' + __('messages.create')" />

  <App
    :breadcrumbs="[
      { label: __('messages.databases'), to: '/database' },
      { label: __('messages.create') },
    ]"
  >
    <Form
      :item="item"
      :types="types"
      :namespaces="namespaces"
      @submit="submit"
    />
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link, useRemember } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Form from "./Form.vue";
import { reactive } from "@vue/reactivity";

export default {
  components: {
    App,
    Head,
    Link,
    Form,
  },
  props: {
    types: Array,
    namespaces: Array,
  },
  setup(props) {
    const item = reactive({
      name: null,
      type: null,
      namespace_id: null,
      is_public: false,
    });
    return { item };
  },
};
</script>