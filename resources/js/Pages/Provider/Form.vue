<template>
  <div class="card">
    <TabView ref="tabview1" :activeIndex="activetab">
      <TabPanel :header="__('messages.details')">
        <div class="p-fluid formgrid grid">
          <div class="field col-12 md:col-6">
            <label for="name">
              {{ __("validation.attributes.name") }}
            </label>
            <InputText
              id="name"
              type="text"
              v-model="item.name"
              :class="{ 'p-invalid': !!errors.name }"
            />
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
          </div>
        </div>
        <div>
          <Button
            :label="__('messages.save')"
            class="p-button-success"
            @click="submit"
          />
        </div>
      </TabPanel>
      <TabPanel :header="__('messages.configurations')" :disabled="!isupdate">
        <FormConfiguration
          :types="types"
          :form="form"
          :func="func"
          @submit="submitConfigs"
        />
      </TabPanel>
    </TabView>
  </div>
</template>

<script>
import { reactive, ref } from "vue";
import * as yup from "yup";
import FormConfiguration from "./FormConfiguration.vue";

export default {
  components: { FormConfiguration },
  props: {
    isupdate: Boolean,
    form: Object,
    types: Array,
    activetab: {
      type: Number,
      default: 0,
    },
  },
  setup(props, { emit }) {
    const item = ref(Object.assign({}, props.form));
    const errors = reactive({});
    const type = ref(item.value.type);
    let schema = yup.object().shape({
      name: yup.string().required().nullable(),
      type: yup.string().required().nullable(),
    });

    async function submit() {
      try {
        schema.validateSync(item.value, { abortEarly: false });
        emit("submit", item.value);
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
    async function submitConfigs(config) {
      item.value = Object.assign({}, props.form);
      item.value.config = config;
      schema.validateSync(item.value, { abortEarly: false });
      emit("submit", item.value);
    }
    return {
      item,
      type,
      submit,
      errors,
      submitConfigs,
    };
  },
};
</script>

<style>
</style>