<template>
  <Head :title="__('messages.functions')" />

  <App
    :breadcrumbs="[
      { label: __('messages.functions'), to: route('function.index') },
    ]"
  >
    <div class="card">
      <Link :href="route('function.create')">
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
          field="ns.name"
          :header="__('validation.attributes.namespace')"
          :sortable="true"
        ></Column>
        <Column
          field="is_public"
          :header="__('validation.attributes.is_public')"
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
              :href="route('function.show', { func: slotProps.data.id })"
              class="mr-2"
            >
              <Button icon="pi pi-eye" class="p-button-success" />
            </Link>
            <Link
              :href="route('function.edit', { func: slotProps.data.id })"
              class="mr-2"
            >
              <Button icon="pi pi-pencil" />
            </Link>
            <Button
              icon="pi pi-trash"
              class="p-button-danger"
              @click="deleteItem(slotProps.data.id)"
            />
          </template>
        </Column>
      </DataTable>
    </div>

    <br />
    <hr />
    <Button
      label="showExpressions"
      class="p-button-success"
      @click="showModal = true"
    />
    <Dialog
      header="Expressions"
      v-model:visible="showModal"
      :style="{ width: '80vw' }"
    >
      <expression-builder
        :items="expressions"
        :variables="variables"
        @save="showModal = false"
      />
    </Dialog>
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { useConfirm } from "primevue/useconfirm";
import ExpressionBuilder from "./ExpressionBuilder/Index.vue";
import { ref } from "@vue/reactivity";

export default {
  components: {
    App,
    Head,
    Link,
    ExpressionBuilder,
  },
  props: {
    items: Array,
    types: Object,
  },
  setup(props) {
    const expressions = ref([]);
    const confirm = useConfirm();

    function deleteItem(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          Inertia.visit(route("function.delete", { func: id }), {
            method: "DELETE",
          });
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }

    const showModal = ref(false);
    const variables = [
      { name: "vstring", type: "string" },
      { name: "vinteger", type: "integer" },
      { name: "vdouble", type: "double" },
      { name: "vbool", type: "bool" },
      { name: "varray_of_string", type: "array_of_string" },
      { name: "varray_of_number", type: "array_of_number" },
      { name: "varray_of_object", type: "array_of_object" },
      { name: "vobject", type: "object" },
    ];
    return { deleteItem, expressions, showModal, variables };
  },
};
</script>
