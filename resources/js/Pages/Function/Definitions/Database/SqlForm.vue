<template>
  <div class="p-fluid formgrid grid flex justify-content-center">
    <div class="field col-12 md:col-10">
      <label for="name">
        {{ __("validation.attributes.name") }}
      </label>
      <InputText
        id="name"
        :class="{ 'p-invalid': !!errors.name }"
        type="text"
        v-model="item.name"
      />
      <small class="p-error">{{ errors.name }}</small>
    </div>
    <div class="field col-12 md:col-10">
      <label for="type">
        {{ __("validation.attributes.type") }}
      </label>
      <InputText id="typeValue" type="hidden" v-model="item.type" />
      <Dropdown
        id="type"
        v-model="type"
        :options="types"
        optionLabel="label"
        optionValue="type"
        placeholder="Select a type"
        @change="item.type = type"
        :class="{ 'p-invalid': !!errors.type }"
      />
      <small class="p-error">{{ errors.type }}</small>
    </div>
    <div class="field col-12 md:col-10">
      <label for="sql">
        {{ __("messages.sql_commands") }}
      </label>
      <v-ace-editor
        v-model:value="item.sql"
        lang="sql"
        theme="chrome"
        style="height: 100px"
      />
      <small class="p-error">{{ errors.sql }}</small>
    </div>
    <div class="field col-12 md:col-10">
      <label for="order">
        {{ __("messages.order") }}
      </label>
      <InputNumber
        id="order"
        :class="{ 'p-invalid': !!errors.order }"
        v-model="item.order"
      />
      <small class="p-error">{{ errors.order }}</small>
    </div>
    <div class="field col-12 md:col-10">
      <Button
        :label="__('messages.save')"
        class="p-button-success"
        @click="save()"
      />
    </div>
  </div>
</template>

<script>
import { computed, reactive, ref } from "vue";
import { VAceEditor } from "vue3-ace-editor";
import "ace-builds/src-noconflict/mode-sql";
import * as yup from "yup";

export default {
  components: {
    VAceEditor,
  },
  props: {
    fieldTypes: Array,
    command: Object,
  },
  setup(props, { emit }) {
    const errors = reactive({});
    const type = ref(props.command.type);

    const types = [
      { label: "Command", type: "command" },
      { label: "Query", type: "query" },
    ];
    const item = reactive({
      id: props.command.id,
      name: props.command.name,
      type: props.command.type,
      sql: props.command.sql,
      order: props.command.order,
    });

    let schema = yup.object().shape({
      name: yup.string().required().nullable(),
      type: yup.string().required().nullable(),
      order: yup.number(),
      sql: yup.string().required(),
    });

    async function save() {
      try {
        schema.validateSync(item, { abortEarly: false });
        emit("submit", item);
      } catch (err) {
        if (err.inner) {
          for (const er in errors) {
            errors[er] = "";
          }
          for (const error of err.inner) {
            errors[error.path] = error.message;
          }
        }
      }
    }
    return {
      type,
      types,
      save,
      errors,
      item,
    };
  },
};
</script>

<style>
</style>