<template>
  <Head :title="__('messages.projects')" />

  <App :breadcrumbs="[{ label: __('messages.projects'), to: '/project' }]">
    <Link href="/project/create">
      <Button
        :label="__('messages.create_new')"
        class="mb-2"
        icon="pi pi-plus"
      />
    </Link>
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
          <Link :href="'/project/' + slotProps.data.id">
            <Button :label="__('messages.edit')" icon="pi pi-pencil" />
          </Link>
          <Button
            :label="__('messages.delete')"
            @click="deleteProject(slotProps.data.id)"
            icon="pi pi-trash"
            class="ml-2 p-button-danger"
          />
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
import { useConfirm } from "primevue/useconfirm";

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
    const confirm = useConfirm();
    const activeId = computed(() =>
      props.activeProject ? props.activeProject.id : ""
    );

    async function activateProject(id) {
      const { data } = await axios.post(
        route("project.activate", { project: id })
      );
      //activeId.value = data.id;
      Inertia.reload();
    }

    async function deleteProject(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          Inertia.visit(route("project.delete", { project: id }), {
            method: "DELETE",
          });
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    return { activateProject, deleteProject, activeId };
  },
};
</script>
