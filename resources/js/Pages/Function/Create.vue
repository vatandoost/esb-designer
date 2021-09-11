<template>
  <Head :title="__('messages.functions') + ' > ' + __('messages.create')" />

  <App
    :breadcrumbs="[
      { label: __('messages.functions'), to: route('function.index') },
      { label: __('messages.create') },
    ]"
  >
    <Detail
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
import Detail from "./Forms/Detail.vue";
import { reactive } from "@vue/reactivity";

export default {
  components: {
    App,
    Head,
    Link,
    Detail,
  },
  props: {
    types: Array,
    fieldTypes: Array,
    namespaces: Array,
  },
  setup(props) {
    const item = reactive({
      name: null,
      timeout: 0,
      type: null,
      namespace_id: null,
      is_public: false,
    });
    function submit() {
      Inertia.post(route("function.store"), item);
    }
    return { item, submit };
  },
};
</script>