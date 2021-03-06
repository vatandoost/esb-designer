<template>
  <ConfirmDialog></ConfirmDialog>
  <Toast />
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
            <img alt="Logo" :src="logo" width="150" />
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

      <Message severity="error" :closable="false" v-if="errorText != ''">
        <div v-html="errorText" />
      </Message>
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
import logoImg from "../../assets/logo_transparent.png";

export default {
  props: {
    breadcrumbs: {
      type: Array,
      default: [],
    },
  },
  data() {
    const data = {
      layoutMode: "static",
      layoutColorMode: "light",
      staticMenuInactive: false,
      overlayMenuActive: false,
      mobileMenuActive: false,
    };

    return data;
  },
  mounted: function () {
    if (this.$page.props.toast != null) {
      this.$toast.add({
        severity: this.$page.props.toast.severity,
        summary: this.$page.props.toast.summary,
        detail: this.$page.props.toast.detail,
        life: 3000,
      });
    }
    if (this.$page.props.errors != null) {
      //console.log("errors", this.$page.props.errors);
      // this.$toast.add({
      //   severity: this.$page.props.toast.severity,
      //   summary: this.$page.props.toast.summary,
      //   detail: this.$page.props.toast.detail,
      //   life: 3000,
      // });
    }
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
    errorText() {
      return Object.values(this.$page.props.errors).join("<br />");
    },
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
    menu() {
      const mainMenu = [
        {
          label: this.__("messages.dashboard"),
          icon: ["fas", "tachometer-alt"],
          to: route("dashboard"),
        },
        {
          label: this.__("messages.projects"),
          to: route("project.index"),
          icon: ["fas", "cube"],
        },
      ];
      const activeMenu = [
        {
          label: this.__("messages.namespaces"),
          to: route("namespace.index"),
          icon: ["fas", "folder-open"],
        },
        {
          label: this.__("messages.functions"),
          to: route("function.index"),
          icon: ["fas", "project-diagram"],
        },
        {
          label: this.__("messages.adapters"),
          to: route("adapter.index"),
          icon: ["fas", "retweet"],
        },
        {
          label: this.__("messages.databases"),
          to: route("database.index"),
          icon: ["fas", "database"],
        },
        {
          label: this.__("messages.providers"),
          to: route("provider.index"),
          icon: ["fas", "cubes"],
        },
        {
          label: this.__("messages.users"),
          to: route("user.index"),
          icon: ["fas", "users"],
        },
        /* {
          label: this.__("messages.variables"),
          to: "/variable",
          icon: ["fas", "wrench"],
        }, */
      ];
      if (this.$page.props.activeProject != null) {
        return mainMenu.concat(activeMenu);
      }
      return mainMenu;
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
