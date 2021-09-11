<template>
  <Head :title="__('messages.functions') + ' > ' + func.name" />

  <App
    :breadcrumbs="[
      { label: __('messages.functions'), to: route('function.index') },
      { label: func.name, to: route('function.show', { func: func.id }) },
      { label: __('messages.definition') },
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
        <database v-if="func.type == 'db'" :options="options" :func="func" />
      </template>
    </Card>
  </App>
</template>

<script>
import { ref } from "vue";
import Detail from "./Forms/Detail.vue";
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Database from "./Definitions/Database.vue";

export default {
  components: {
    App,
    Head,
    Link,
    Detail,
    Database,
  },
  props: {
    func: Object,
    options: Object,
  },
  data() {
    return {
      menu: [
        {
          label: "Detail",
          icon: "pi pi-fw pi-bars",
          url: route("function.show", { func: this.func.id }),
        },
        {
          label: "Parameters",
          icon: "pi pi-fw pi-list",
          url: route("function.parameters", { func: this.func.id }),
        },
        {
          label: "Definition",
          icon: "pi pi-fw pi-sitemap",
          class: "p-highlight",
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