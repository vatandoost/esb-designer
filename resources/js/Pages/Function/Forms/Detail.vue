<template>
  <div class="card">
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
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
    </div>
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="namespace">
          {{ __("validation.attributes.namespace") }}
        </label>
        <InputText
          id="namespaceValue"
          type="hidden"
          v-model="item.namespace_id"
        />
        <Dropdown
          id="namespace"
          v-model="namespace"
          :options="namespaces"
          optionLabel="name"
          optionValue="id"
          placeholder="Select a namespace"
          @change="item.namespace_id = namespace"
          :class="{ 'p-invalid': !!errors.namespace_id }"
        />
        <small class="p-error">{{ errors.namespace_id }}</small>
      </div>
    </div>
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
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
    </div>
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="timeout">
          {{ __("validation.attributes.timeout") }}
        </label>
        <InputText
          id="timeout"
          :class="{ 'p-invalid': !!errors.timeout }"
          type="text"
          v-model="item.timeout"
        />
        <small class="p-error">{{ errors.timeout }}</small>
      </div>
    </div>
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="is_public">
          {{ __("validation.attributes.is_public") }}
        </label>
        <br />
        <InputSwitch id="is_public" v-model="item.is_public" />
      </div>
    </div>
    <div>
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
    item: Object,
    types: Array,
    namespaces: Array,
  },
  setup(props, { emit }) {
    const errors = reactive({});
    const type = ref(props.item.type);
    const namespace = ref(props.item.namespace_id);

    let schema = yup.object().shape({
      name: yup.string().required().nullable(),
      timeout: yup.number(),
      namespace_id: yup.string().required().nullable(),
      type: yup.string().required().nullable(),
      is_public: yup.boolean(),
    });

    async function save() {
      try {
        schema.validateSync(props.item, { abortEarly: false });
        emit("submit");
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
    return { type, namespace, save, errors };
  },
};
</script>

<style>
</style>