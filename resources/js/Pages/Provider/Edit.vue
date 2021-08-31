<template>
  <Head :title="__('messages.providers') + ' > ' + __('messages.update')" />

  <App
    :breadcrumbs="[
      { label: __('messages.providers'), to: route('provider.index') },
      { label: __('messages.update') },
    ]"
  >
    <Form
      :form="form"
      :types="types"
      :funcs="funcs"
      :activetab="activetab"
      @submit="submit"
      isupdate
    />
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { reactive } from "vue";
import Form from "./Form.vue";

export default {
  components: {
    App,
    Head,
    Link,
    Form,
  },
  props: {
    item: Object,
    types: Array,
    funcs: Array,
    activetab: {
      type: Number,
      default: 0,
    },
  },
  setup(props) {
    const form = reactive({
      name: props.item.name,
      type: props.item.type,
      function_id: props.item.function_id,
      function_config: props.item.function_config,
      config: props.item.config,
    });

    function submit(data) {
      console.log("submit data", data);
      Inertia.post(route("provider.update", { provider: props.item.id }), data);
    }

    return { form, submit };
  },
};
</script>