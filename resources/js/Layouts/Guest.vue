<template>
  <slot />
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    BreezeApplicationLogo,
    Link,
  },
};
</script>
