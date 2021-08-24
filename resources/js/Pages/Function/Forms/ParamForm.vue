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
      <InputText id="typeValue" type="hidden" v-model="item.value_type" />
      <Dropdown
        id="type"
        v-model="fieldType"
        :options="fieldTypes"
        optionLabel="label"
        optionValue="type"
        placeholder="Select a type"
        @change="item.value_type = fieldType"
        :class="{ 'p-invalid': !!errors.value_type }"
      />
      <small class="p-error">{{ errors.value_type }}</small>
    </div>
    <div class="field col-12 md:col-10">
      <label for="dir_type">
        {{ __("validation.attributes.dir_type") }}
      </label>
      <InputText id="typeValue" type="hidden" v-model="item.dir_type" />
      <Dropdown
        id="dir_type"
        v-model="dirType"
        :options="dirTypes"
        optionLabel="label"
        optionValue="code"
        placeholder="Select direction"
        @change="item.dir_type = dirType"
        :class="{ 'p-invalid': !!errors.dir_type }"
      />
      <small class="p-error">{{ errors.dir_type }}</small>
    </div>
    <div class="field col-12 md:col-10">
      <label for="name">
        {{ __("validation.attributes.default") }}
      </label>
      <Textarea
        id="default"
        :class="{ 'p-invalid': !!errors.default }"
        type="text"
        v-model="item.default"
      />
      <small class="p-error">{{ errors.default }}</small>
    </div>
    <div class="field col-12 md:col-10">
      <label for="is_public">
        {{ __("validation.attributes.is_public") }}
      </label>
      <br />
      <InputSwitch id="is_public" v-model="item.is_assignable" />
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
import { reactive, ref } from "vue";
import * as yup from "yup";

export default {
  props: {
    fieldTypes: Array,
  },
  setup(props, { emit }) {
    const errors = reactive({});
    const fieldType = ref();
    const dirType = ref();
    const dirTypes = [
      { label: "In", code: 0 },
      { label: "Out", code: 1 },
    ];
    const item = reactive({
      name: "",
      value_type: "",
      default: "",
      dir_type: 0,
      is_assignable: true,
    });

    let schema = yup.object().shape({
      name: yup.string().required().nullable(),
      value_type: yup.string().required().nullable(),
      dir_type: yup.number().required(),
      default: yup.string(),
      is_assignable: yup.boolean(),
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
      fieldType,
      dirType,
      dirTypes,
      save,
      errors,
      item,
    };
  },
};
</script>

<style>
</style>