<template>
  <Head :title="__('messages.functions') + ' > ' + __('messages.update')" />

  <App
    :breadcrumbs="[
      { label: __('messages.functions'), to: route('function.index') },
      { label: item.name, to: route('function.show', { func: item.id }) },
      { label: __('messages.update') },
    ]"
  >
    <Detail
      :item="form"
      :types="types"
      :namespaces="namespaces"
      @submit="submit"
    />
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
    namespaces: Array,
  },
  setup(props) {
    console.log(props.item);
    const form = reactive({
      name: props.item.name,
      type: props.item.type,
      namespace_id: props.item.namespace_id,
      is_public: props.item.is_public,
    });

    function submit() {
      Inertia.post(route("function.update", { func: props.item.id }), form);
    }

    return { form, submit };
  },
};
</script>