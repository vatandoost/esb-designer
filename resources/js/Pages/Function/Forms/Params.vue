<template>
  <Button
    :label="__('messages.create_new')"
    class="mb-2"
    icon="pi pi-plus"
    @click="addNewParam()"
  />

  <DataTable :value="item.params" stripedRows responsiveLayout="scroll">
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
        {{ fieldTypes[slotProps.data.type] }}
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

  <br />
  <hr />
  <Button
    label="showExpressions"
    class="p-button-success"
    @click="showModal = true"
  />

  <Dialog
    :header="__('messages.create_new')"
    v-model:visible="showParamForm"
    :style="{ width: '80vw' }"
  >
    <param-form :fieldTypes="fieldTypes" :type="type" />
  </Dialog>

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
</template>

<script>
import { reactive, ref } from "vue";
import ParamForm from "./ParamForm.vue";

export default {
  components: { ParamForm },
  props: {
    item: Object,
    type: String,
    fieldTypes: Array,
  },
  setup(props) {
    const showParamForm = ref(false);

    function addNewParam() {
      showParamForm.value = true;
    }
    async function save() {}
    return { save, showParamForm, addNewParam };
  },
};
</script>

<style>
</style>