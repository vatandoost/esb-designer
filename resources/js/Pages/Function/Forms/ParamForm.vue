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
        {{ __("validation.attributes.parent_id") }}
      </label>
      <InputText id="typeValue" type="hidden" v-model="item.parent_id" />
      <Dropdown
        id="type"
        showClear
        v-model="parent"
        :options="fields"
        optionLabel="name"
        optionValue="id"
        placeholder="Select parent"
        @change="item.parent_id = parent"
        :class="{ 'p-invalid': !!errors.parent_id }"
      />
      <small class="p-error">{{ errors.parent_id }}</small>
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
    <div class="field col-12 md:col-10" v-if="dirType == 1">
      <label for="path">
        {{ __("validation.attributes.path") }}
      </label>
      <InputText
        id="path"
        :class="{ 'p-invalid': !!errors.path }"
        type="text"
        v-model="item.path"
      />
      <small class="p-error">{{ errors.path }}</small>
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
      <label for="is_assignable">
        {{ __("validation.attributes.is_assignable") }}
      </label>
      <br />
      <InputSwitch id="is_assignable" v-model="item.is_assignable" />
    </div>
    <div class="field col-12 md:col-10">
      <label for="is_required">
        {{ __("validation.attributes.is_required") }}
      </label>
      <br />
      <InputSwitch id="is_required" v-model="item.is_required" />
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
import * as yup from "yup";

export default {
  props: {
    fieldTypes: Array,
    param: Object,
    params: Array,
  },
  setup(props, { emit }) {
    const errors = reactive({});
    const fieldType = ref(props.param.value_type);
    const dirType = ref(props.param.dir_type);
    const parent = ref(props.param.parent_id);

    const fields = computed(() => {
      return props.params.filter((p) => {
        if (p.id == props.param.id) return false;
        if (p.dir_type != props.param.dir_type) return false;
        if (!["object", "array_of_object"].includes(p.value_type)) return false;
        return true;
      });
    });
    const dirTypes = [
      { label: "In", code: 0 },
      { label: "Out", code: 1 },
    ];
    const item = reactive({
      id: props.param.id,
      name: props.param.name,
      value_type: props.param.value_type,
      default: props.param.defaul,
      dir_type: props.param.dir_type,
      is_assignable: props.param.is_assignable,
      parent_id: props.param.parent_id,
      path: props.param.path,
      is_required: props.param.is_required,
      formula: props.param.formula,
    });

    let schema = yup.object().shape({
      name: yup.string().required().nullable(),
      value_type: yup.string().required().nullable(),
      dir_type: yup.number().required(),
      default: yup.string(),
      parent_id: yup.string().uuid().nullable(),
      path: yup.string().nullable(),
      is_required: yup.boolean(),
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
      fields,
      parent,
    };
  },
};
</script>

<style>
</style>