<template>
  <Head :title="__('messages.functions') + ' > ' + func.name" />

  <App
    :breadcrumbs="[
      { label: __('messages.functions'), to: route('function.index') },
      { label: func.name, to: route('function.show', { func: func.id }) },
      { label: __('messages.parameters') },
    ]"
  >
    <TabMenu :model="menu" :exact="false">
      <template #item="{ item }">
        <Link :href="item.url" class="p-menuitem-link" role="presentation">
          <span class="p-menuitem-icon" :class="item.icon"></span>
          <span class="p-menuitem-text">{{ item.label }}</span>
        </Link>
      </template>
    </TabMenu>
    <Card>
      <template #content>
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
        <DataTable
          :value="params"
          stripedRows
          responsiveLayout="scroll"
          v-model:expandedRows="expandedRows"
          dataKey="id"
        >
          <Column :expander="true" headerStyle="width: 3rem" />
          <Column
            field="name"
            :header="__('validation.attributes.name')"
            :sortable="true"
          ></Column>
          <Column
            field="is_assignable"
            :header="__('validation.attributes.is_assignable')"
            :sortable="true"
          ></Column>
          <Column
            field="dir_type"
            :header="__('validation.attributes.direction')"
            :sortable="true"
          >
            <template #body="slotProps">
              {{ dirTypes[slotProps.data.dir_type] }}
            </template>
          </Column>
          <Column field="formula" :header="__('messages.has_expression')">
            <template #body="slotProps">
              {{
                slotProps.data.formula && slotProps.data.formula.length
                  ? __("messages.yes")
                  : __("messages.no")
              }}
            </template>
          </Column>
          <Column
            field="type"
            :header="__('validation.attributes.type')"
            :sortable="true"
          >
            <template #body="slotProps">
              {{ ftypes[slotProps.data.value_type] }}
            </template>
          </Column>
          <Column field="id" header="">
            <template #body="slotProps">
              <Button
                icon="pi pi-sitemap"
                class="p-button-success"
                @click="openExpressionsModal(slotProps.data)"
              />
              <Button
                icon="pi pi-pencil"
                class="ml-1"
                @click="openUpdateForm(slotProps.data)"
              />
              <Button
                icon="pi pi-trash"
                class="p-button-danger ml-1"
                @click="deleteItem(slotProps.data.id)"
              />
            </template>
          </Column>

          <template #expansion="slotProps">
            <div class="p-5">
              <div class="grid">
                <div class="col-12 md:col-4">
                  <Fieldset :legend="__('messages.details')">
                    <div class="grid py-1">
                      <div class="col-3 font-bold">
                        {{ __("validation.attributes.name") }}
                      </div>
                      <div class="col">{{ slotProps.data.name }}</div>
                    </div>
                    <div class="grid py-1">
                      <div class="col-3 font-bold">
                        {{ __("validation.attributes.is_required") }}
                      </div>
                      <div class="col">{{ slotProps.data.is_required ? __("messages.yes") : __("messages.no") }}</div>
                    </div>
                    <div class="grid py-1" v-if="slotProps.data.parent_id">
                      <div class="col-3 font-bold">
                        {{ __("validation.attributes.parent_id") }}
                      </div>
                      <div class="col">
                        {{
                          params.find((p) => slotProps.data.parent_id == p.id)
                            ?.name
                        }}
                      </div>
                    </div>
                    <div class="grid py-1" v-if="slotProps.data.dir_type == 1">
                      <div class="col-3 font-bold">
                        {{ __("validation.attributes.path") }}
                      </div>
                      <div class="col">{{ slotProps.data.path }}</div>
                    </div>

                    <div class="grid py-1">
                      <div class="col-3 font-bold">
                        {{ __("validation.attributes.default") }}
                      </div>
                      <div class="col">{{ slotProps.data.default }}</div>
                    </div>
                  </Fieldset>
                </div>
                <div class="col-12 md:col-8">
                  <Fieldset :legend="__('messages.expressions')">
                    <span
                      v-if="
                        !slotProps.data.formula ||
                        slotProps.data.formula.length == 0
                      "
                    >
                      {{ __("messages.no_expression_exist") }} </span
                    ><DataTable
                      v-else
                      :value="slotProps.data.formula"
                      stripedRows
                      responsiveLayout="scroll"
                    >
                      <Column
                        field="order"
                        :header="__('messages.order')"
                        :sortable="true"
                      >
                      </Column>
                      <Column
                        field="condition_string"
                        :header="__('messages.condition')"
                      ></Column>
                      <Column
                        field="expression_string"
                        :header="__('messages.expression')"
                      >
                      </Column>
                    </DataTable>
                  </Fieldset>
                </div>
              </div>
            </div>
          </template>
        </DataTable>
      </template>
    </Card>
  </App>

  <Dialog
    header="Expressions"
    v-model:visible="showExpressionsModal"
    :style="{ width: '80vw' }"
  >
    <expression-builder
      :items="expressions"
      :variables="variables"
      @save="saveExpressions"
    />
  </Dialog>
  <Dialog
    :header="formParam.id == '' ? __('messages.create') : __('messages.update')"
    v-model:visible="showParamForm"
    :style="{ width: '50vw' }"
  >
    <param-form
      :fieldTypes="fieldTypes"
      :params="params"
      @submit="submitForm"
      :param="formParam"
    />
  </Dialog>
</template>

<script>
import { reactive, ref } from "vue";
import Detail from "./Forms/Detail.vue";
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import ParamForm from "./Forms/ParamForm.vue";
import { useConfirm } from "primevue/useconfirm";
import ExpressionBuilder from "./ExpressionBuilder/Index.vue";

export default {
  components: {
    App,
    Head,
    Link,
    Detail,
    ParamForm,
    ExpressionBuilder,
  },
  props: {
    func: Object,
    params: Array,
    fieldTypes: Array,
  },
  data() {
    return {
      expandedRows: [],
      menu: [
        {
          label: "Detail",
          icon: "pi pi-fw pi-bars",
          url: route("function.show", { func: this.func.id }),
        },
        {
          label: "Parameters",
          icon: "pi pi-fw pi-list",
          class: "p-highlight",
          url: route("function.parameters", { func: this.func.id }),
        },
        {
          label: "Definition",
          icon: "pi pi-fw pi-sitemap",
          url: route("function.definition", { func: this.func.id }),
        },
      ],
    };
  },
  setup(props) {
    const showExpressionsModal = ref(false);
    const expressions = ref([]);
    const variables = ref([]);
    const confirm = useConfirm();
    const showParamForm = ref(false);
    const ftypes = {};
    props.fieldTypes.map((item) => {
      ftypes[item.type] = item.label;
    });
    const dirTypes = {
      0: "In",
      1: "Out",
    };
    const formParam = reactive({
      id: "",
      name: "",
      value_type: "",
      default: "",
      dir_type: null,
      parent_id: null,
      path: "",
      is_required: false,
      is_assignable: true,
      formula: [],
    });

    function submitForm(data) {
      data.function_id = props.func.id;
      if (data.id != "") {
        Inertia.post(
          route("function.parameter.edit", { funcParam: data.id }),
          data
        );
      } else {
        Inertia.post(route("function.parameter.save"), data);
      }
      showParamForm.value = false;
    }

    function deleteItem(id) {
      confirm.require({
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        acceptClass: "p-button-danger",
        accept: () => {
          Inertia.visit(route("function.parameter.delete", { funcParam: id }), {
            method: "DELETE",
          });
        },
        reject: () => {
          //console.log("reject");
        },
      });
    }
    function openCreateForm() {
      formParam.id = "";
      formParam.name = "";
      formParam.value_type = "";
      formParam.default = "";
      formParam.dir_type = null;
      formParam.parent_id = null;
      formParam.path = "";
      formParam.is_required = false;
      formParam.is_assignable = true;
      formParam.formula = [];

      showParamForm.value = true;
    }
    function openUpdateForm(item) {
      formParam.id = item.id;
      formParam.name = item.name;
      formParam.value_type = item.value_type;
      formParam.default = item.default;
      formParam.dir_type = item.dir_type;
      formParam.is_assignable = item.is_assignable;
      formParam.parent_id = item.parent_id;
      formParam.path = item.path;
      formParam.is_required = item.is_required;
      formParam.formula = item.formula;

      showParamForm.value = true;
    }
    function openExpressionsModal(item) {
      formParam.id = item.id;
      formParam.name = item.name;
      formParam.value_type = item.value_type;
      formParam.default = item.default;
      formParam.dir_type = item.dir_type;
      formParam.is_assignable = item.is_assignable;
      formParam.parent_id = item.parent_id;
      formParam.path = item.path;
      formParam.is_required = item.is_required;
      formParam.formula = item.formula;
      expressions.value = JSON.parse(JSON.stringify(item.formula));
      variables.value = [];
      props.params.map((v) => {
        if (item.dir_type == 0 && v.dir_type == 1) {
          // return out params only if current is out
          return;
        }
        variables.value.push({
          name: v.name,
          type: v.value_type,
        });
      });
      showExpressionsModal.value = true;
    }
    function saveExpressions(data) {
      formParam.formula = data;
      const postData = JSON.parse(JSON.stringify(formParam));
      const id = formParam.id;
      console.log("function.parameter.edit", postData, id);
      Inertia.post(
        route("function.parameter.edit", { funcParam: id }),
        postData
      );
      showExpressionsModal.value = false;
    }

    return {
      showParamForm,
      submitForm,
      ftypes,
      dirTypes,
      deleteItem,
      formParam,
      openCreateForm,
      openUpdateForm,
      expressions,
      variables,
      showExpressionsModal,
      openExpressionsModal,
      saveExpressions,
    };
  },
};
</script>

<style>
</style>