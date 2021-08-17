<template>
  <Head title="Project List" />

  <App :breadcrumbs="[{ label: 'Projects', to: '/project' }]">
    <DataTable :value="projects" stripedRows responsiveLayout="scroll">
            <Column field="name" header="Name"></Column>
            <Column field="owner_id" header="Owner"></Column>
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
