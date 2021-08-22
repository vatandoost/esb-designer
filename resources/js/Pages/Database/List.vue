<template>
  <Head :title="__('messages.databases')" />

  <App :breadcrumbs="[{ label: __('messages.databases'), to: '/database' }]">
    <Link :href="route('database.create')">
      <Button
        :label="__('messages.create_new')"
        class="mb-2"
        icon="pi pi-plus"
      />
    </Link>
    <DataTable :value="items" stripedRows responsiveLayout="scroll">
      <Column
        field="name"
        :header="__('messages.name')"
        :sortable="true"
      ></Column>
      <Column
        field="type"
        :header="__('validation.attributes.type')"
        :sortable="true"
      >
        <template #body="slotProps">
          {{ types[slotProps.data.type] }}
        </template>
      </Column>
      <Column field="id" header="">
        <template #body="slotProps">
          <Link
            :href="route('database.edit', { db: slotProps.data.id })"
            class="mr-2"
          >
            <Button :label="__('messages.edit')" icon="pi pi-pencil" />
          </Link>
          <Button
            :label="__('messages.delete')"
            icon="pi pi-trash"
            class="p-button-danger"
            @click="deleteDb(slotProps.data.id)"
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
    types: Object,
  },
  setup(props) {
    const confirm = useConfirm();

    function deleteDb(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          Inertia.visit(route("database.delete", { db: id }), {
            method: "DELETE",
          });
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    return { deleteDb };
  },
};
</script>
