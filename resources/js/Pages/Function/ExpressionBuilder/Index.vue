<template>
  <DataTable :value="items" stripedRows responsiveLayout="scroll">
    <Column field="order" :header="__('messages.order')" :sortable="true">
    </Column>
    <Column
      field="condition_string"
      :header="__('messages.condition')"
    ></Column>
    <Column field="espression_string" :header="__('messages.expression')">
    </Column>
    <Column field="id" header="">
      <template #body="slotProps">
        <Button :label="__('messages.edit')" icon="pi pi-pencil" />
        <Button
          :label="__('messages.delete')"
          icon="pi pi-trash"
          class="p-button-danger"
          @click="deleteExp(slotProps.data.id)"
        />
      </template>
    </Column>
  </DataTable>
  <Button
    :label="__('messages.create_new')"
    class="mb-2"
    icon="pi pi-plus"
    @click="createExp()"
  />
  <div class="card">
    <Splitter  class="p-mb-5">
      <SplitterPanel class="p-2">
        <condition-panel />
      </SplitterPanel>
      <SplitterPanel class="p-2">
        <expression-panel />
      </SplitterPanel>
    </Splitter>
  </div>
</template>

<script>
import { ref } from "vue";
import { useConfirm } from "primevue/useconfirm";
import ConditionPanel from "./ConditionPanel.vue";
import ExpressionPanel from "./ExpressionPanel.vue";

export default {
  props: {},
  components: {
    ConditionPanel,
    ExpressionPanel,
  },
  setup(props) {
    const confirm = useConfirm();
    function deleteExp(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          console.log("accept");
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    function createExp() {
      console.log("");
    }
    return { deleteExp, createExp };
  },
};
</script>

<style>
</style>