<template>
  <Head title="Project List" />

  <App :breadcrumbs="[{ label: __('messages.projects'), to: '/project' }]">
    <DataTable :value="projects" stripedRows responsiveLayout="scroll">
            <Column field="name" :header="__('messages.name')"></Column>
            <Column field="owner_id" :header="__('messages.owner')"></Column>
        </DataTable>
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  components: {
    App,
    Head,
  },
  props: {
    projects: Array,
  },
  setup(props) {

  },
};
</script>
