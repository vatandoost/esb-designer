<template>
  <div class="layout-footer">
    <span class="footer-text" style="margin-right: 5px">PrimeVue</span>
    <img :src="logoImg" alt="sigma" width="20" />
    <span class="footer-text" style="margin-left: 5px">Theme and Layout</span>
  </div>
</template>

<script>
import logoImg from "../../assets/logo.png";
export default {
  name: "AppFooter",
  setup() {
    return { logoImg };
  },
};
</script>

<style scoped>
</style>