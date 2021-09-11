<template>
  <Head :title="__('messages.namespaces')" />

  <App
    :breadcrumbs="[
      { label: __('messages.namespaces'), to: route('namespace.index') },
    ]"
  >
    <Link :href="route('namespace.create')">
      <Button
        :label="__('messages.create_new')"
        class="mb-2"
        icon="pi pi-plus"
      />
    </Link>
    <Button
      :label="__('messages.import')"
      icon="pi pi-cloud-upload"
      class="ml-2 mb-2 p-button-success"
    />

    <DataTable :value="items" stripedRows responsiveLayout="scroll">
      <Column
        field="name"
        :header="__('messages.name')"
        :sortable="true"
      ></Column>
      <Column field="id" header="">
        <template #body="slotProps">
          <Link :href="route('namespace.edit', { ns: slotProps.data.id })">
            <Button :label="__('messages.edit')" icon="pi pi-pencil" />
          </Link>
          <Button
            :disabled="activeProject.main_namespace_id == slotProps.data.id"
            :label="__('messages.delete')"
            @click="deleteNamespace(slotProps.data.id)"
            icon="pi pi-trash"
            class="ml-2 p-button-danger"
          />
          <Button
            :label="__('messages.export')"
            icon="pi pi-cloud-download"
            class="ml-2 p-button-help"
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
    items: Array,
    activeProject: Object,
  },
  setup(props) {
    const confirm = useConfirm();
    async function deleteNamespace(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          Inertia.visit(route("namespace.delete", { ns: id }), {
            method: "DELETE",
          });
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    return { deleteNamespace };
  },
};
</script>
