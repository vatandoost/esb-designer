<template>
  <div class="layout-topbar">
    <button class="p-link layout-menu-button" @click="onMenuToggle">
      <span class="pi pi-bars"></span>
    </button>
    <div class="layout-topbar-icons">
      <Link
        :href="route('project.index')"
        v-if="this.$page.props.activeProject != null"
      >
        <Button
          :label="this.$page.props.activeProject.name"
          class="p-button-primary"
          style="color: #fff"
        />
      </Link>
      <Link :href="route('logout')" method="post">
        <button class="p-link">
          <span class="layout-topbar-item-text">User</span>
          <span class="layout-topbar-icon pi pi-power-off"></span>
        </button>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: { Link },
  methods: {
    onMenuToggle(event) {
      this.$emit("menu-toggle", event);
    },
  },
};
</script>