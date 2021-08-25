<template>
  <div class="flex justify-content-first">
    <Dropdown
      v-model="variable"
      :options="variables"
      optionLabel="name"
      optionValue="name"
      placeholder="Select Variable"
      @change="
        secondValue = null;
        secondType = null;
        operator == null;
      "
    />

    <Dropdown
      v-if="variable != null"
      v-model="operator"
      :options="operators"
      optionLabel="name"
      optionValue="code"
      placeholder="Select Operator"
      @change="secondType = null"
    />
    <div
      v-if="operator != null && types && types.length"
      class="flex justify-content-first"
    >
      <Dropdown
        v-model="secondType"
        :options="types"
        optionLabel="name"
        optionValue="type"
        placeholder="Select type"
        class="mr-2"
        @change="secondValue = null"
      />

      <!-- related input -->

      <div v-if="secondType == 'variable'">
        <Dropdown
          v-model="secondValue"
          :options="secondVariables"
          optionLabel="name"
          optionValue="name"
          placeholder="Select Variable"
        />
      </div>
      <div v-if="['array_of_string', 'array_of_number'].includes(secondType)">
        <Chips v-model="secondValue" />
      </div>
      <div v-if="secondType == 'integer'">
        <InputNumber
          id="secondValue"
          v-model="secondValue"
          mode="decimal"
          :useGrouping="false"
        />
      </div>
      <div v-if="secondType == 'double'">
        <InputNumber
          id="secondValue"
          v-model="secondValue"
          mode="decimal"
          :minFractionDigits="1"
          :maxFractionDigits="20"
          :useGrouping="false"
        />
      </div>
      <div v-if="secondType == 'bool'">
        <InputSwitch v-model="secondValue" />
      </div>
      <div v-if="secondType == 'string'">
        <InputText v-model="secondValue" />
      </div>
    </div>
  </div>
  <div class="flex justify-content-end">
    <Button icon="pi pi-save" :label="__('messages.save')" @click="save()" />
  </div>
</template>

<script>
import { computed, ref } from "vue";
export default {
  props: {
    config: {
      type: Object,
    },
    node: {
      type: Object,
    },
    variables: {
      type: Array,
      default: [],
    },
  },
  setup(props) {
    const secondValue = ref(
      props.node.structure ? props.node.structure.secondValue : null
    );
    const secondType = ref(
      props.node.structure ? props.node.structure.secondType : null
    );
    const variable = ref(
      props.node.structure ? props.node.structure.variable : null
    );
    const operator = ref(
      props.node.structure ? props.node.structure.operator : null
    );

    const operators = computed(() => {
      const type = getFirstType();
      let validOperators = [];
      if (props.config.type_operators) {
        validOperators = Object.keys(props.config.type_operators[type]);
      }
      const result = [];
      for (const op in props.config.operators) {
        if (!validOperators.includes(op)) continue;
        result.push({
          name: props.config.operators[op],
          code: op,
        });
      }
      return result;
    });
    const types = computed(() => {
      const items = [
        {
          name: "Variable",
          type: "variable",
        },
      ];
      const type = getFirstType();

      const validTypes = props.config.type_operators[type][operator.value];
      if (!validTypes || validTypes.length == 0) {
        return [];
      }
      for (const type in props.config.types) {
        if (validTypes.includes(type)) {
          items.push({
            name: props.config.types[type],
            type: type,
          });
        }
      }
      return items;
    });
    const secondVariables = computed(() => {
      const validTypes = types.value.map((item) => item.type);
      return props.variables.filter((v) => validTypes.includes(v.type));
    });

    function getFirstType() {
      const selected = props.variables.find(function (v) {
        return v.name == variable.value;
      });
      if (!selected) {
        return "string";
      }
      return selected.type;
    }

    function save() {
      props.node.label =
        variable.value +
        " " +
        props.config.operators[operator.value] +
        " " +
        secondValue.value;

      props.node.structure = {
        variable: variable.value,
        operator: operator.value,
        secondType: secondType.value,
        secondValue: secondValue.value,
      };
      props.node.display = false;
    }

    return {
      types,
      secondValue,
      secondType,
      operators,
      variable,
      operator,
      secondVariables,
      save,
    };
  },
};
</script>

<style>
</style>