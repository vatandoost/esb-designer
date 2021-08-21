<template>
  <Head :title="__('messages.namespaces') + ' > ' + __('messages.update')" />

  <App
    :breadcrumbs="[
      { label: __('messages.namespaces'), to: '/namespace' },
      { label: __('messages.update') },
    ]"
  >
    <div class="card">
      <form @submit.prevent="submit">
        <div class="p-fluid formgrid grid">
          <div class="field col-6">
            <label for="name">{{ __("messages.name") }}</label>
            <InputText id="name" type="text" v-model="form.name" />
          </div>
        </div>
        <div>
          <Button
            type="submit"
            :label="__('messages.save')"
            class="p-button-success"
          />
        </div>
      </form>
    </div>
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { reactive } from "vue";

export default {
  components: {
    App,
    Head,
    Link,
  },
  props: {
    item: Object,
  },
  setup(props) {
    const form = reactive({
      name: props.item.name,
    });

    function submit() {
      Inertia.post(route("namespace.update", { ns: props.item.id }), form);
    }

    return { form, submit };
  },
};
</script>