<template>
  <Head :title="__('messages.namespaces')" />

  <App :breadcrumbs="[{ label: __('messages.namespaces'), to: '/namespace' }]">
    <Link href="/namespace/create">
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
      <Column field="id" header="">
        <template #body="slotProps">
          <Link :href="'/namespace/' + slotProps.data.id">
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
    items: Array,
  },
  setup(props) {
    return {};
  },
};
</script>
