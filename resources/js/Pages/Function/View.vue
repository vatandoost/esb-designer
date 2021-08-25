<template>
  <Head :title="__('messages.functions') + ' > ' + func.name" />

  <App
    :breadcrumbs="[
      { label: __('messages.functions'), to: route('function.index') },
      { label: func.name },
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
        <div class="grid">
          <div class="col-12 md:col-6">
            <div class="grid py-1">
              <div class="col-3 font-bold">
                {{ __("validation.attributes.name") }}
              </div>
              <div class="col">{{ func.name }}</div>
            </div>
            <div class="grid py-1">
              <div class="col-3 font-bold">
                {{ __("validation.attributes.namespace") }}
              </div>
              <div class="col">{{ func.ns.name }}</div>
            </div>
            <div class="grid py-1">
              <div class="col-3 font-bold">
                {{ __("validation.attributes.type") }}
              </div>
              <div class="col">{{ types[func.type] }}</div>
            </div>
            <div class="grid py-1">
              <div class="col-3 font-bold">
                {{ __("validation.attributes.is_public") }}
              </div>
              <div class="col">
                {{ func.is_public ? __("messages.yes") : __("messages.no") }}
              </div>
            </div>
          </div>
        </div>
      </template>
      <template #footer>
        <Link :href="route('function.edit', { func: func.id })">
          <Button icon="pi pi-pencil" :label="__('messages.update')" />
        </Link>
      </template>
    </Card>
  </App>
</template>

<script>
import { ref } from "vue";
import Detail from "./Forms/Detail.vue";
import Params from "./Forms/Params.vue";
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    App,
    Head,
    Link,
    Detail,
    Params,
  },
  props: {
    func: Object,
    types: Array,
  },
  data() {
    return {
      menu: [
        {
          label: "Detail",
          icon: "pi pi-fw pi-home",
          class: "p-highlight",
          url: route("function.show", { func: this.func.id }),
        },
        {
          label: "Parameters",
          icon: "pi pi-fw pi-home",
          url: route("function.parameters", { func: this.func.id }),
        },
        {
          label: "Definition",
          icon: "pi pi-fw pi-home",
          url: route("function.definition", { func: this.func.id }),
        },
      ],
    };
  },
  setup(props) {
    return {};
  },
};
</script>

<style>
</style>