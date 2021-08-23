<template>
  <div class="card" v-if="!displayEditor">
    <DataTable :value="records" stripedRows responsiveLayout="scroll">
      <Column field="order" :header="__('messages.order')" :sortable="true">
      </Column>
      <Column
        field="condition_string"
        :header="__('messages.condition')"
      ></Column>
      <Column field="expression_string" :header="__('messages.expression')">
      </Column>
      <Column field="id" header="">
        <template #body="slotProps">
          <Button
            :label="__('messages.edit')"
            icon="pi pi-pencil"
            @click="editExp(slotProps.data.id)"
          />
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
      class="p-button-primary ml-1"
      icon="pi pi-plus"
      @click="createExp()"
    />
    <Button
      icon="pi pi-save"
      :label="__('messages.save')"
      class="p-button-success ml-1"
      @click="saveAll()"
    />
  </div>
  <div class="card" v-if="displayEditor">
    <Splitter class="p-mb-5">
      <SplitterPanel class="p-2">
        <condition-panel
          :nodes="nodes"
          :variables="variables"
          :config="config"
        />
      </SplitterPanel>
      <SplitterPanel class="p-2">
        <expression-panel
          :variables="variables"
          :config="config"
          :value="expression"
        />
      </SplitterPanel>
    </Splitter>
    <Button
      icon="pi pi-back"
      :label="__('messages.cancel')"
      class="p-button-info"
      @click="cancelEdition()"
    />
    <Button
      icon="pi pi-save"
      :label="__('messages.save')"
      class="p-button-success ml-1"
      @click="saveEdition()"
    />
  </div>
</template>

<script>
import { ref } from "vue";
import { useConfirm } from "primevue/useconfirm";
import ConditionPanel from "./ConditionPanel.vue";
import ExpressionPanel from "./ExpressionPanel.vue";
import axios from "axios";

export default {
  props: {
    items: {
      type: Array,
      default: [],
    },
    variables: {
      type: Array,
      default: [],
    },
  },
  components: {
    ConditionPanel,
    ExpressionPanel,
  },
  setup(props, { emit }) {
    const records = ref(props.items);
    const expression = ref({ structure: {}, expression: "" });
    const nodes = ref([
      {
        key: "root",
        label: "AND",
        data: "AND",
        removable: false,
        children: [],
      },
    ]);
    const editionKey = ref("");

    const displayEditor = ref(false);

    const config = ref({
      operators: [],
      types: [],
      type_operators: [],
      valid_functions: [],
    });
    async function getSetting() {
      const res = await axios.get(route("utility.conditions"));
      config.value = res.data;
    }
    getSetting();

    const confirm = useConfirm();

    function editExp(id) {
      const exp = records.value.find((v) => v.id == id);
      editionKey.value = id;
      expression.value.structure = exp.expression_structure;
      expression.value.expression = exp.expression_string;
      nodes.value = exp.condition_structure;
      displayEditor.value = true;
    }

    function deleteExp(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          console.log("accept");
          records.value = records.value.filter((v) => v.id !== id);
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    function createExp() {
      expression.value = { structure: {}, expression: "" };
      nodes.value = [
        {
          key: "root",
          label: "AND",
          data: "AND",
          removable: false,
          children: [],
        },
      ];
      editionKey.value = Math.round(Math.random() * 9999999);
      displayEditor.value = true;
    }
    function saveEdition() {
      const exp = records.value.find((v) => v.id == editionKey.value);
      if (exp) {
        exp.expression_structure = expression.value.structure;
        exp.expression_string = expression.value.expression;
        exp.condition_string = getConditionLabel(nodes.value);
        exp.condition_structure = nodes.value;
      } else {
        records.value.push({
          id: editionKey.value,
          order: records.value.length + 1,
          expression_structure: expression.value.structure,
          expression_string: expression.value.expression,
          condition_string: getConditionLabel(nodes.value),
          condition_structure: nodes.value,
        });
      }
      displayEditor.value = false;
    }
    function cancelEdition() {
      displayEditor.value = false;
    }
    function getConditionLabel(nodes, type = "AND") {
      const result = [];
      for (const node of nodes) {
        let label = "";
        if (node.type !== "rule") {
          label = getConditionLabel(node.children, node.data);
          if (label.trim() != "") {
            result.push("( " + label + " )");
          }
          continue;
        }
        label = "true";
        if (node.structure)
          label =
            node.structure.variable +
            " " +
            config.value.operators[node.structure.operator] +
            " " +
            node.structure.secondValue;
        result.push(label);
      }
      return result.join(" " + type + " ");
    }
    function saveAll() {
      console.log("saveAll", records.value);
      emit("save", records.value);
    }
    return {
      records,
      editExp,
      deleteExp,
      createExp,
      nodes,
      config,
      expression,
      displayEditor,
      saveEdition,
      cancelEdition,
      saveAll,
    };
  },
};
</script>

<style>
</style>