<template>
  <Fieldset legend="Condition">
    <div>
      <Textarea :modelValue="getLabel(nodes)" :autoResize="true" rows="1" disabled class="mb-2 w-full" />
    </div>
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
  </Fieldset>
</template>

<script>
import { ref } from "vue";
import RuleStructure from "./RuleStructure.vue";

export default {
  components: { RuleStructure },
  props: {
    config: {
      type: Object,
    },
    nodes: {
      type: Array,
      default: [
        {
          key: "root",
          label: "AND",
          data: "AND",
          removable: false,
          children: [],
        },
      ],
    },
    variables: {
      type: Array,
      default: [],
    },
  },
  setup(props) {
    const groupOptions = ref(["AND", "OR"]);

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
      props.nodes = [removeDeletedNodes(props.nodes[0])];
      expandedKeys.value = { ...expandedKeys.value };
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
    function getLabel(nodes, type = "AND") {
      const result = [];
      for (const node of nodes) {
        let label = "";
        if (node.type !== "rule") {
          label = getLabel(node.children, node.data);
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
            props.config.operators[node.structure.operator] +
            " " +
            node.structure.secondValue;
        result.push(label);
      }
      return result.join(" " + type + " ");
    }

    return {
      groupOptions,
      getNewRule,
      getNewGroup,
      updateTree,
      expandedKeys,
      getLabel,
    };
  },
};
</script>

<style >
span.p-treenode-label {
  width: 100% !important;
}
.p-tree {
  padding: 0.5rem;
}
</style>