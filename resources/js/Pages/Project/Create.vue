<template>
  <Head title="Project create" />

  <App
    :breadcrumbs="[
      { label: __('messages.projects'), to: '/project' },
      { label: __('messages.create') },
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
        <div class="p-fluid formgrid grid">
          <div class="field col-6">
            <Button
              type="submit"
              :label="__('messages.save')"
              class="p-button-success"
            />
          </div>
        </div>
      </form>
    </div>
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link, useRemember } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    App,
    Head,
    Link,
  },
  setup() {
    const form = useRemember({
      name: "",
    });

    function submit() {
      Inertia.post(route('project.store'), form);
    }

    return { form, submit };
  },
};
</script>