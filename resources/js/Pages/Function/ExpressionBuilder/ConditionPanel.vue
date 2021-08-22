<template>
  <h3>Condition</h3>
  <Tree :value="nodes" :expandedKey="expandedKeys">
    <template #default="slotProps">
      <div class="w-full flex justify-content-between">
        <SelectButton v-model="slotProps.node.data" :options="groupOptions">
          <template #option="slotProps">
            {{ slotProps.option }}
          </template>
        </SelectButton>
        <div>
          <Button
            class="p-button-outlined ml-2"
            icon="pi pi-plus"
            label="Group"
            @click="
              slotProps.node.children.push(getNewGroup(slotProps.node)) &&
                updateTree()
            "
          />
          <Button
            class="p-button-outlined ml-2"
            icon="pi pi-plus"
            label="Rule"
            @click="
              slotProps.node.children.push(getNewRule(slotProps.node)) &&
                updateTree()
            "
          />
          <Button
            class="p-button-outlined ml-2 p-button-danger"
            icon="pi pi-trash"
            v-if="
              typeof slotProps.node.removable == 'undefined' ||
              slotProps.node.removable
            "
            @click="(slotProps.node.deleted = true) && updateTree()"
          />
        </div>
      </div>
    </template>
    <template #rule="slotProps">
      <div class="w-full flex justify-content-between">
        <Chip :label="slotProps.node.label" />
        <div>
          <Button
            class="p-button-outlined ml-2"
            icon="pi pi-pencil"
            @click="slotProps.node.display = true"
          />
          <Button
            class="p-button-outlined ml-2 p-button-danger"
            icon="pi pi-trash"
            v-if="
              typeof slotProps.node.removable == 'undefined' ||
              slotProps.node.removable
            "
            @click="(slotProps.node.deleted = true) && updateTree()"
          />
        </div>
      </div>
      <Dialog
        header="Rule structure"
        v-model:visible="slotProps.node.display"
        :style="{ width: '50vw' }"
      >
        <rule-structure
          :config="config"
          :node="slotProps.node"
          :variables="variables"
        />
      </Dialog>
    </template>
  </Tree>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import RuleStructure from "./RuleStructure.vue";

export default {
  components: { RuleStructure },
  setup(props) {
    const config = ref({
      operators: [],
      types: [],
      type_operators: [],
    });
    async function getSetting() {
      const res = await axios.get(route("utility.conditions"));
      config.value = res.data;
    }
    getSetting();

    const groupOptions = ref(["AND", "OR"]);
    const nodes = ref([
      {
        key: "root",
        label: "AND",
        data: "AND",
        removable: false,
        children: [],
      },
    ]);
    const expandedKeys = ref({ root: true });
    function getNewRule(parent) {
      expandedKeys.value[parent.key] = true;
      return {
        key: "r-" + Math.random(),
        label: "true",
        data: "Resume Document",
        type: "rule",
      };
    }
    function getNewGroup(parent) {
      const groupKey = "g-" + Math.random();
      expandedKeys.value[parent.key] = true;
      return {
        key: groupKey,
        label: "AND",
        data: "AND",
        children: [],
      };
    }
    function updateTree() {
      console.log(nodes.value);
      nodes.value = [removeDeletedNodes(nodes.value[0])];
      expandedKeys.value = { ...expandedKeys.value };
      console.log(expandedKeys.value);
    }
    function removeDeletedNodes(node) {
      if (node.deleted) {
        return null;
      }
      if (node.children && node.children.length) {
        const children = [];
        for (const child of node.children) {
          const editedChild = removeDeletedNodes(child);
          if (editedChild) {
            children.push(editedChild);
          }
        }
        node.children = children;
      }
      return node;
    }
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
    return {
      nodes,
      groupOptions,
      getNewRule,
      getNewGroup,
      updateTree,
      expandedKeys,
      config,
      variables,
    };
  },
};
</script>

<style >
span.p-treenode-label {
  width: 100% !important;
}
</style>