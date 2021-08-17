<template>
  <div :class="containerClass" @click="onWrapperClick">
    <AppTopBar @menu-toggle="onMenuToggle" />

    <transition name="layout-sidebar">
      <div
        :class="sidebarClass"
        @click="onSidebarClick"
        v-show="isSidebarVisible()"
      >
        <div class="layout-logo">
          <Link href="/">
            <img alt="Logo" :src="logo" width="40" />
          </Link>
        </div>

        <AppProfile />
        <AppMenu :model="menu" @menuitem-click="onMenuItemClick" />
      </div>
    </transition>

    <div class="layout-main">
      <Breadcrumb
        :home="{ icon: 'pi pi-home', to: '/dashboard' }"
        :model="breadcrumbs"
        class="mb-5"
      >
        <template #item="{ item }">
          <Link :href="item.to" v-if="item.icon">
            <i :class="'pi ' + item.icon"></i>
            {{ item.label }}
          </Link>
          <Link :href="item.to" v-else>{{ item.label }}</Link>
        </template>
      </Breadcrumb>
      <slot />
    </div>

    <AppFooter />
  </div>
</template>

<script>
import AppTopBar from "@/Layouts/App/AppTopbar.vue";
import AppProfile from "@/Layouts/App/AppProfile.vue";
import AppMenu from "@/Layouts/App/AppMenu.vue";
import AppFooter from "@/Layouts/App/AppFooter.vue";
import { Link } from "@inertiajs/inertia-vue3";
import logoImg from "../../assets/logo.png";

export default {
  props: {
    breadcrumbs: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      layoutMode: "static",
      layoutColorMode: "light",
      staticMenuInactive: false,
      overlayMenuActive: false,
      mobileMenuActive: false,
      menu: [
        { label: "Dashboard", icon: "pi pi-fw pi-home", to: "/dashboard" },
        { label: "Projects", icon: "pi pi-fw pi-th-large", to: "/project" },
        { label: "Namespaces", icon: "pi pi-fw pi-th-large", to: "/namespace" },
        { label: "Database", icon: "pi pi-fw pi-th-large", to: "/database" },
        { label: "Providers", icon: "pi pi-fw pi-th-large", to: "/provider" },
        { label: "Variables", icon: "pi pi-fw pi-th-large", to: "/variable" },

        /* {
          label: "Utilities",
          icon: "pi pi-fw pi-globe",
          items: [
            { label: "Display", icon: "pi pi-fw pi-desktop", to: "/display" },
            {
              label: "Elevation",
              icon: "pi pi-fw pi-external-link",
              to: "/elevation",
            },
          ],
        },
        {
          label: "Menu Hierarchy",
          icon: "pi pi-fw pi-search",
          items: [
            {
              label: "Submenu 1",
              icon: "pi pi-fw pi-bookmark",
              items: [
                {
                  label: "Submenu 1.1",
                  icon: "pi pi-fw pi-bookmark",
                  items: [
                    { label: "Submenu 1.1.1", icon: "pi pi-fw pi-bookmark" },
                    { label: "Submenu 1.1.2", icon: "pi pi-fw pi-bookmark" },
                    { label: "Submenu 1.1.3", icon: "pi pi-fw pi-bookmark" },
                  ],
                },
                {
                  label: "Submenu 1.2",
                  icon: "pi pi-fw pi-bookmark",
                  items: [
                    { label: "Submenu 1.2.1", icon: "pi pi-fw pi-bookmark" },
                    { label: "Submenu 1.2.2", icon: "pi pi-fw pi-bookmark" },
                  ],
                },
              ],
            },
          ],
        }, */
      ],
    };
  },
  methods: {
    onWrapperClick() {
      if (!this.menuClick) {
        this.overlayMenuActive = false;
        this.mobileMenuActive = false;
      }

      this.menuClick = false;
    },
    onMenuToggle() {
      this.menuClick = true;

      if (this.isDesktop()) {
        if (this.layoutMode === "overlay") {
          if (this.mobileMenuActive === true) {
            this.overlayMenuActive = true;
          }

          this.overlayMenuActive = !this.overlayMenuActive;
          this.mobileMenuActive = false;
        } else if (this.layoutMode === "static") {
          this.staticMenuInactive = !this.staticMenuInactive;
        }
      } else {
        this.mobileMenuActive = !this.mobileMenuActive;
      }

      event.preventDefault();
    },
    onSidebarClick() {
      this.menuClick = true;
    },
    onMenuItemClick(event) {
      if (event.item && !event.item.items) {
        this.overlayMenuActive = false;
        this.mobileMenuActive = false;
      }
    },
    onLayoutChange(layoutMode) {
      this.layoutMode = layoutMode;
    },
    onLayoutColorChange(layoutColorMode) {
      this.layoutColorMode = layoutColorMode;
    },
    addClass(element, className) {
      if (element.classList) element.classList.add(className);
      else element.className += " " + className;
    },
    removeClass(element, className) {
      if (element.classList) element.classList.remove(className);
      else
        element.className = element.className.replace(
          new RegExp(
            "(^|\\b)" + className.split(" ").join("|") + "(\\b|$)",
            "gi"
          ),
          " "
        );
    },
    isDesktop() {
      return window.innerWidth > 1024;
    },
    isSidebarVisible() {
      if (this.isDesktop()) {
        if (this.layoutMode === "static") return !this.staticMenuInactive;
        else if (this.layoutMode === "overlay") return this.overlayMenuActive;
        else return true;
      } else {
        return true;
      }
    },
  },
  computed: {
    containerClass() {
      return [
        "layout-wrapper",
        {
          "layout-overlay": this.layoutMode === "overlay",
          "layout-static": this.layoutMode === "static",
          "layout-static-sidebar-inactive":
            this.staticMenuInactive && this.layoutMode === "static",
          "layout-overlay-sidebar-active":
            this.overlayMenuActive && this.layoutMode === "overlay",
          "layout-mobile-sidebar-active": this.mobileMenuActive,
          //'p-input-filled': this.$appState.inputStyle === 'filled',
          "p-ripple-disabled": this.$primevue.config.ripple === false,
        },
      ];
    },
    sidebarClass() {
      return [
        "layout-sidebar",
        {
          "layout-sidebar-dark": this.layoutColorMode === "dark",
          "layout-sidebar-light": this.layoutColorMode === "light",
        },
      ];
    },
    logo() {
      return logoImg;
    },
  },
  beforeUpdate() {
    if (this.mobileMenuActive)
      this.addClass(document.body, "body-overflow-hidden");
    else this.removeClass(document.body, "body-overflow-hidden");
  },
  components: {
    AppTopBar: AppTopBar,
    AppProfile: AppProfile,
    AppMenu: AppMenu,
    AppFooter: AppFooter,
    Link,
  },
};
</script>

<style lang="scss">
</style>
