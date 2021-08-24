<template>
  <Head :title="__('messages.functions') + ' > ' + func.name" />

  <App
    :breadcrumbs="[
      { label: __('messages.functions'), to: route('function.index') },
      { label: func.name, to: route('function.show', { func: func.id }) },
      { label: __('messages.parameters') },
    ]"
  >
    <TabMenu :model="menu" :exact="false">
      <template #item="{ item }">
        <Link :href="item.url" class="p-menuitem-link" role="presentation">
          <span class="p-menuitem-icon" :class="item.icon"></span>
          <span class="p-menuitem-text">{{ item.label }}</span>
        </Link>
      </template>
    </TabMenu>
    <Card>
      <template #content>
        <Toolbar class="mb-4">
          <template #left>
            <Button
              :label="__('messages.create_new')"
              icon="pi pi-plus"
              class="p-button-success p-mr-2"
              @click="showParamForm = true"
            />
          </template>
        </Toolbar>
        <DataTable :value="params" stripedRows responsiveLayout="scroll">
          <Column
            field="name"
            :header="__('validation.attributes.name')"
            :sortable="true"
          ></Column>
          <Column
            field="is_assignable"
            :header="__('validation.attributes.is_assignable')"
            :sortable="true"
          ></Column>
          <Column
            field="type"
            :header="__('validation.attributes.type')"
            :sortable="true"
          >
            <template #body="slotProps">
              {{ ftypes[slotProps.data.value_type] }}
            </template>
          </Column>
          <Column field="id" header="">
            <template #body="slotProps">
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
      </template>
    </Card>
  </App>

  <Dialog
    :header="__('messages.create_new')"
    v-model:visible="showParamForm"
    :style="{ width: '50vw' }"
  >
    <param-form :fieldTypes="fieldTypes" @submit="submitCreateForm" />
  </Dialog>
</template>

<script>
import { ref } from "vue";
import Detail from "./Forms/Detail.vue";
import Params from "./Forms/Params.vue";
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import ParamForm from "./Forms/ParamForm.vue";

export default {
  components: {
    App,
    Head,
    Link,
    Detail,
    Params,
    ParamForm,
  },
  props: {
    func: Object,
    params: Array,
    fieldTypes: Array,
  },
  data() {
    return {
      menu: [
        {
          label: "Detail",
          icon: "pi pi-fw pi-home",
          url: route("function.show", { func: this.func.id }),
        },
        {
          label: "Parameters",
          icon: "pi pi-fw pi-home",
          class: "p-highlight",
          url: route("function.parameters", { func: this.func.id }),
        },
        {
          label: "Definition",
          icon: "pi pi-fw pi-home",
          url: route("function.definition", { func: this.func.id }),
        },
      ],
    };
  },
  setup(props) {
    const showParamForm = ref(false);
    const ftypes = {};
    props.fieldTypes.map((item) => {
      ftypes[item.type] = item.label;
    });

    function submitCreateForm(data) {
      data.function_id = props.func.id;
      Inertia.post(route("function.parameter.save"), data);
      showParamForm.value = false;
    }
    return { showParamForm, submitCreateForm, ftypes };
  },
};
</script>

<style>
</style>