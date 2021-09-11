<template>
  <Fieldset legend="Expression">
    <div>
      <v-ace-editor
        v-model:value="value.expression"
        @init="editorInit"
        lang="javascript"
        theme="chrome"
        style="height: 100px"
        @change="change"
      />
    </div>
    <div class="col-12 mt-2">
      <InlineMessage severity="success" v-if="isValid">Valid</InlineMessage>
      <InlineMessage severity="error" v-if="!isValid">
        Error: {{ __(errorHint) }}
      </InlineMessage>
    </div>
  </Fieldset>
</template>

<script>
import { VAceEditor } from "vue3-ace-editor";
import "ace-builds/src-noconflict/mode-javascript";
import "ace-builds/src-noconflict/theme-chrome";
import { computed, ref, watch } from "vue";
import { parse } from "expression-eval";

export default {
  components: {
    VAceEditor,
  },
  props: {
    config: {
      type: Object,
    },
    variables: {
      type: Array,
      default: [],
    },
    value: {
      type: Object,
      default: {
        structure: {},
        expression: "",
      },
    },
  },
  setup(props) {
    const isValid = ref(true);
    const errorHint = ref("");
    const validFunctions = computed(() =>
      Object.keys(props.config.valid_functions)
    );
    const validVariables = computed(() => props.variables.map((v) => v.name));
    const validOperators = ["+", "%", "*", "/", "-"];

    function editorInit() {
      isValid.value = validate(props.value.expression);
    }
    function change() {
      isValid.value = validate(props.value.expression);
      if (isValid.value) {
        props.value.structure = parse(props.value.expression);
      }
    }
    function validate(exp) {
      if (exp == "") {
        errorHint.value = "";
        return true;
      }
      try {
        const structure = parse(exp);
        const error = checkStructureErrors(structure);
        if (error != "") {
          errorHint.value = error;
          return false;
        }
      } catch {
        if (exp != "") {
          errorHint.value = "messages.errors.syntax_error";
          return false;
        }
      }
      errorHint.value = "";
      return true;
    }
    function checkStructureErrors(structure) {
      let error = "";
      if (structure.type == "Compound") {
        return "messages.errors.compound_limit_error";
      } else if (structure.type == "Literal") {
        return "";
      } else if (structure.type == "BinaryExpression") {
        if (!validOperators.includes(structure.operator)) {
          return "messages.errors.not_valid_operator";
        }
        error = checkStructureErrors(structure.left);
        if (error != "") return error;
        error = checkStructureErrors(structure.right);
        if (error != "") return error;
      } else if (structure.type == "Identifier") {
        if (!validVariables.value.includes(structure.name)) {
          return "messages.errors.not_valid_variable";
        }
      } else if (structure.type == "CallExpression") {
        if (!validFunctions.value.includes(structure.callee.name)) {
          return "messages.errors.not_valid_function";
        }
        for (const arg of structure.arguments) {
          error = checkStructureErrors(arg);
          if (error != "") return error;
        }
      } else {
        return "messages.errors.unknown_expression";
      }
      return "";
    }
    return { editorInit, change, isValid, errorHint, editorInit };
  },
};
</script>

<style>
</style>