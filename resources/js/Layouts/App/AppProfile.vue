<template>
  <div class="layout-profile">
    <button class="p-link layout-profile-link" @click="onClick">
      <span class="username">{{
        $page.props.auth.user.name.toUpperCase()
      }}</span>
      <i class="pi pi-fw pi-cog"></i>
    </button>
    <transition name="layout-submenu-wrapper">
      <ul v-show="expanded">
        <li>
          <Link :href="route('user.profile')">
            <button class="p-link">
              <i class="pi pi-fw pi-user"></i
              ><span>{{ __("messages.profile") }}</span>
            </button>
          </Link>
        </li>
        <li>
          <Link :href="route('logout')" method="post">
            <button class="p-link">
              <i class="pi pi-fw pi-power-off"></i>
              <span>Logout</span>
            </button>
          </Link>
        </li>
      </ul>
    </transition>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },
  data() {
    return {
      expanded: false,
    };
  },
  methods: {
    onClick(event) {
      this.expanded = !this.expanded;
      event.preventDefault();
    },
  },
};
</script>

<style scoped>
</style>