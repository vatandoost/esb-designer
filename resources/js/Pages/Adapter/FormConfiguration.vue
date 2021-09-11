<template>
  <div class="grid">
    <div class="col-12 p-2">
      <Fieldset :legend="__('messages.main_configuaration')" class="mt-5">
        <http-config
          :options="options"
          :mainConfig="mainConfig"
          v-if="form.type == 1"
        />
      </Fieldset>
    </div>
    <div class="col-12 md:col-6 p-2">
      <Fieldset :legend="__('messages.bind_input_parameters')" class="mt-5">
        <Button
          :label="__('messages.add_new')"
          icon="pi pi-plus"
          @click="openInputForm()"
        />
        <DataTable
          :value="functionConfig.input_params"
          stripedRows
          responsiveLayout="scroll"
        >
          <Column field="type" :header="__('messages.type')"></Column>
          <Column field="path" :header="__('messages.path')"></Column>
          <Column field="param" :header="__('messages.parameter')">
            <template #body="slotProps">
              {{ inputParams.find((v) => v.id == slotProps.data.param)?.name }}
            </template>
          </Column>

          <Column field="id" header="">
            <template #body="slotProps">
              <Button icon="pi pi-pencil" @click="editInput(slotProps.data)" />
              <Button
                icon="pi pi-trash"
                class="p-button-danger ml-1"
                @click="deleteInput(slotProps.data.id)"
              />
            </template>
          </Column>
        </DataTable>
      </Fieldset>
    </div>

    <div class="col-12 md:col-6 p-2">
      <Fieldset :legend="__('messages.bind_output_parameters')" class="mt-5">
        <Button
          :label="__('messages.add_new')"
          icon="pi pi-plus"
          @click="openOutputForm()"
        />
        <DataTable
          :value="functionConfig.output_params"
          stripedRows
          responsiveLayout="scroll"
        >
          <Column field="param" :header="__('messages.parameter')">
            <template #body="slotProps">
              {{ outputParams.find((v) => v.id == slotProps.data.param)?.name }}
            </template>
          </Column>
          <Column field="alias" :header="__('messages.alias')"></Column>

          <Column field="id" header="">
            <template #body="slotProps">
              <Button icon="pi pi-pencil" @click="editOutput(slotProps.data)" />
              <Button
                icon="pi pi-trash"
                class="p-button-danger ml-1"
                @click="deleteOutput(slotProps.data.id)"
              />
            </template>
          </Column>
        </DataTable>
      </Fieldset>
    </div>

    <div class="col-12 p-2">
      <Button
        :label="__('messages.save_configs')"
        class="p-button-success p-button-lg"
        icon="pi pi-save"
        @click="submit"
      />
    </div>
  </div>
  <Dialog
    :header="__('messages.add_new')"
    v-model:visible="showInputForm"
    :style="{ width: '50vw' }"
  >
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="type">
          {{ __("validation.attributes.type") }}
        </label>
        <Dropdown
          id="type"
          v-model="mapInputForm.type"
          :options="inputTypes"
          optionLabel="label"
          optionValue="type"
          placeholder="Select a type"
        />
      </div>
    </div>
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="path">
          {{ __("validation.attributes.path") }}
        </label>
        <InputText id="path" v-model="mapInputForm.path" />
      </div>
    </div>
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="inputParam">
          {{ __("messages.function_parameter") }}
        </label>
        <Dropdown
          id="inputParam"
          v-model="mapInputForm.param"
          :options="inputParams"
          optionLabel="name"
          optionValue="id"
          placeholder="Select a parameter"
        />
      </div>
    </div>
    <div>
      <Button
        :label="__('messages.save')"
        class="p-button-success"
        @click="saveInput"
      />
    </div>
  </Dialog>
  <Dialog
    :header="__('messages.add_new')"
    v-model:visible="showOutputForm"
    :style="{ width: '50vw' }"
  >
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="inputParam">
          {{ __("messages.function_parameter") }}
        </label>
        <Dropdown
          id="inputParam"
          v-model="mapOutputForm.param"
          :options="outputParams"
          optionLabel="name"
          optionValue="id"
          placeholder="Select a parameter"
        />
      </div>
    </div>
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="path">
          {{ __("messages.alias") }}
        </label>
        <InputText id="path" v-model="mapOutputForm.alias" />
      </div>
    </div>
    <div>
      <Button
        :label="__('messages.save')"
        class="p-button-success"
        @click="saveOutput"
      />
    </div>
  </Dialog>
</template>

<script>
import { computed, reactive, ref } from "vue";
import axios from "axios";
import { useConfirm } from "primevue/useconfirm";
import HttpConfig from "./Configs/HttpConfig.vue";

export default {
  components: {
    HttpConfig,
  },
  props: {
    form: Object,
    types: Array,
    funcs: Array,
    func: Object,
  },
  setup(props, { emit }) {
    const mainConfig = ref(Object.assign({}, props.form.config));
    const options = ref({});
    const functionConfig = ref(Object.assign({}, props.form.function_config));
    const inputTypes = ref([]);
    const confirm = useConfirm();
    const mapInputForm = reactive({
      param: "",
      type: "",
      path: "",
    });
    const mapOutputForm = reactive({
      param: "",
      alias: "",
    });
    const inputParams = computed(() => {
      if (!options.value || !options.value.func?.params) {
        return [];
      }
      return options.value.func.params.filter(
        (p) => p.dir_type == 0 && p.is_assignable
      );
    });
    const outputParams = computed(() => {
      if (!options.value || !options.value.func?.params) {
        return [];
      }
      return options.value.func.params.filter(
        (p) => p.dir_type == 1 && p.is_assignable
      );
    });
    const showInputForm = ref(false);
    const showOutputForm = ref(false);

    async function submit() {
      emit("submit", functionConfig.value, mainConfig.value);
    }
    async function loadOptions() {
      const { data } = await axios.get(
        route("adapter.options", {
          func: props.form.function_id,
          type: props.form.type,
        })
      );
      options.value = data;
      inputTypes.value = data.inputTypes;
    }
    loadOptions();

    function openInputForm() {
      Object.assign(mapInputForm, {
        id: Math.random(),
        param: "",
        type: "",
        path: "",
      });
      showInputForm.value = true;
    }
    function saveInput() {
      functionConfig.value.input_params =
        functionConfig.value.input_params.filter(
          (v) => v.id !== mapInputForm.id
        );
      functionConfig.value.input_params.push(Object.assign({}, mapInputForm));
      showInputForm.value = false;
    }
    function editInput(data) {
      Object.assign(mapInputForm, data);
      showInputForm.value = true;
    }
    function deleteInput(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          functionConfig.value.input_params =
            functionConfig.value.input_params.filter((v) => v.id !== id);
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }

    function openOutputForm() {
      Object.assign(mapOutputForm, {
        id: Math.random(),
        param: "",
        alias: "",
      });
      showOutputForm.value = true;
    }
    function saveOutput() {
      functionConfig.value.output_params =
        functionConfig.value.output_params.filter(
          (v) => v.id !== mapOutputForm.id
        );
      functionConfig.value.output_params.push(Object.assign({}, mapOutputForm));
      showOutputForm.value = false;
    }
    function editOutput(data) {
      Object.assign(mapOutputForm, data);
      showOutputForm.value = true;
    }
    function deleteOutput(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          functionConfig.value.output_params =
            functionConfig.value.output_params.filter((v) => v.id !== id);
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    return {
      mainConfig,
      options,
      functionConfig,
      submit,
      showInputForm,
      showOutputForm,
      openInputForm,
      openOutputForm,
      inputParams,
      outputParams,
      mapInputForm,
      mapOutputForm,
      inputTypes,
      saveInput,
      editInput,
      deleteInput,
      saveOutput,
      editOutput,
      deleteOutput,
    };
  },
};
</script>

<style>
</style>