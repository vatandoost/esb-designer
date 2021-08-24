<template>
  <Head :title="__('messages.databases') + ' > ' + __('messages.update')" />

  <App
    :breadcrumbs="[
      { label: __('messages.databases'), to: '/database' },
      { label: __('messages.update') },
    ]"
  >
    <Detail :item="item" :types="types" :namespaces="namespaces" />
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { reactive } from "vue";
import Detail from "./Forms/Detail.vue";

export default {
  components: {
    App,
    Head,
    Link,
    Detail,
  },
  props: {
    item: Object,
    types: Array,
  },
  setup(props) {
    const form = reactive({
      name: props.item.name,
      type: props.item.type,
      host: props.item.host,
      port: props.item.port,
      db: props.item.db,
      schema: props.item.schema,
      username: props.item.username,
      password: props.item.password,
    });

    function submit() {
      Inertia.post(route("database.update", { db: props.item.id }), form);
    }

    return { form, submit };
  },
};
</script>