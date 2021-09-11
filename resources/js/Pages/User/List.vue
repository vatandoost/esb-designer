<template>
  <Head :title="__('messages.users')" />

  <App
    :breadcrumbs="[
      { label: __('messages.users'), to: route('user.index') },
    ]"
  >
    <Link :href="route('user.create')">
      <Button
        :label="__('messages.create_new')"
        class="mb-2"
        icon="pi pi-plus"
      />
    </Link>

    <DataTable :value="items" stripedRows responsiveLayout="scroll">
      <Column
        field="name"
        :header="__('validation.attributes.name')"
        :sortable="true"
      ></Column>
      <Column
        field="email"
        :header="__('validation.attributes.email')"
        :sortable="true"
      ></Column>
      <Column field="id" header="">
        <template #body="slotProps">
          <Link :href="route('user.edit', { user: slotProps.data.id })">
            <Button :label="__('messages.edit')" icon="pi pi-pencil" />
          </Link>
          <Button
            :disabled="activeProject.main_user_id == slotProps.data.id"
            :label="__('messages.delete')"
            @click="deleteUser(slotProps.data.id)"
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
    async function deleteUser(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          Inertia.visit(route("user.delete", { user: id }), {
            method: "DELETE",
          });
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    return { deleteUser };
  },
};
</script>
