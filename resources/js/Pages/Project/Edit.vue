<template>
  <Head title="Project update" />

  <App
    :breadcrumbs="[
      { label: __('messages.projects'), to: '/project' },
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { reactive } from "vue";
import { useToast } from "primevue/usetoast";

export default {
  components: {
    App,
    Head,
    Link,
  },
  props: {
    project: Object,
  },
  setup(props) {
    const form = reactive({
      name: props.project.name,
    });

    const toast = useToast();

    function submit() {
      Inertia.post("/project/" + props.project.id, form);
    }

    return { form, submit };
  },
};
</script>