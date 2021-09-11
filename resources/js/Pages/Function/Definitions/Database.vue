<template>
  <Fieldset :legend="__('messages.details')">
    <div class="p-fluid formgrid grid">
      <div class="field col-12 md:col-6">
        <label for="db">
          {{ __("messages.database") }}
        </label>
        <InputText id="dbValue" type="hidden" v-model="config.db" />
        <Dropdown
          id="db"
          v-model="db"
          :options="options.databases"
          optionLabel="name"
          optionValue="id"
          placeholder="Select a Database"
          @change="config.db = db"
        />
      </div>
    </div>
    <div>
      <Button
        type="submit"
        :label="__('messages.save')"
        class="p-button-success"
        @click="updateServer"
      />
    </div>
  </Fieldset>

  <Fieldset :legend="__('messages.sql_commands')" class="mt-2" v-if="config.db">
    <Toolbar class="mb-4">
      <template #left>
        <Button
          :label="__('messages.create_new')"
          icon="pi pi-plus"
          class="p-button-success p-mr-2"
          @click="openCreateForm()"
        />
      </template>
    </Toolbar>
    <DataTable :value="config.commands" stripedRows responsiveLayout="scroll">
      <Column field="name" :header="__('validation.attributes.name')"></Column>
      <Column field="type" :header="__('validation.attributes.type')"> </Column>
      <Column field="order" :header="__('messages.order')" :sortable="true">
        <template #body="slotProps">
          <InputNumber v-model="slotProps.data.order" />
        </template>
      </Column>
      <Column field="id" header="">
        <template #body="slotProps">
          <Button icon="pi pi-pencil" @click="editCommand(slotProps.data.id)" />
          <Button
            icon="pi pi-trash"
            class="p-button-danger ml-1"
            @click="deleteCommand(slotProps.data.id)"
          />
        </template>
      </Column>
    </DataTable>
  </Fieldset>
  <Dialog
    :header="
      formCommand.name == '' ? __('messages.create') : __('messages.update')
    "
    v-model:visible="showCommandForm"
    :style="{ width: '50vw' }"
  >
    <sql-form @submit="submitForm" :command="formCommand" />
  </Dialog>
</template>

<script>
import { reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import SqlForm from "./Database/SqlForm.vue";
import { useConfirm } from "primevue/useconfirm";

export default {
  components: {
    SqlForm,
  },
  props: {
    func: Object,
    options: Object,
  },
  setup(props) {
    const showCommandForm = ref(false);
    const confirm = useConfirm();
    const formCommand = reactive({
      id: "",
      name: "",
      type: "",
      sql: "",
      order: "",
    });

    const config = reactive(Object.assign({ commands: [] }, props.func.config));
    const db = ref(config.db);
    function updateServer() {
      Inertia.post(
        route("function.definition.store", { func: props.func.id }),
        { config }
      );
    }

    function submitForm(item) {
      const command = config.commands.find((v) => v.id == item.id);
      if (command) {
        command.name = item.name;
        command.type = item.type;
        command.sql = item.sql;
        command.order = item.order;
      } else {
        config.commands.push({
          id: item.id,
          name: item.name,
          type: item.type,
          sql: item.sql,
          order: item.order,
        });
      }
      updateServer();
      showCommandForm.value = false;
    }

    function openCreateForm() {
      formCommand.id = Math.random();
      formCommand.name = "";
      formCommand.type = "";
      formCommand.sql = "";
      formCommand.order = "";
      showCommandForm.value = true;
    }
    function editCommand(id) {
      const command = config.commands.find((v) => v.id == id);
      formCommand.id = command.id;
      formCommand.name = command.name;
      formCommand.type = command.type;
      formCommand.sql = command.sql;
      formCommand.order = command.order;
      showCommandForm.value = true;
    }
    function deleteCommand(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          console.log("accept");
          config.commands = config.commands.filter((v) => v.id !== id);
          updateServer();
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    return {
      db,
      config,
      updateServer,
      editCommand,
      deleteCommand,
      openCreateForm,
      showCommandForm,
      formCommand,
      submitForm,
    };
  },
};
</script>

<style>
</style>