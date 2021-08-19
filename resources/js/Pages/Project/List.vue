<template>
  <Head title="Project List" />

  <App :breadcrumbs="[{ label: __('messages.projects'), to: '/project' }]">
    <DataTable :value="projects" stripedRows responsiveLayout="scroll">
      <Column field="name" :header="__('messages.name')" :sortable="true">
        <template #body="slotProps">
          {{ slotProps.data.name }}
          <Badge
            v-if="slotProps.data.id == activeId"
            severity="success"
            :value="__('messages.active')"
            class="p-mr-2"
          ></Badge>
        </template>
      </Column>
      <Column field="id" header="">
        <template #body="slotProps">
          <Button
            :label="__('messages.activate')"
            :disabled="slotProps.data.id == activeId"
            @click="activateProject(slotProps.data.id)"
            icon="pi pi-check"
            class="mr-2 p-button-success"
          />
          <Link :href="'/project/update/' + slotProps.data.id">
            <Button :label="__('messages.edit')" icon="pi pi-pencil" />
          </Link>
        </template>
      </Column>
    </DataTable>
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { computed, ref } from "vue";
import axios from "axios";

export default {
  components: {
    App,
    Head,
    Link,
  },
  props: {
    projects: Array,
    activeProject: Object,
  },
  setup(props) {
    const activeId = computed(() =>
      props.activeProject ? props.activeProject.id : ""
    );

    async function activateProject(id) {
      const { data } = await axios.get("/project/activate/" + id);
      //activeId.value = data.id;
      Inertia.reload();
    }
    return { activateProject, activeId };
  },
};
</script>
