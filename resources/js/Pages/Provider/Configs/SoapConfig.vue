<template>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="base_url">
        {{ __("messages.base_url") }}
      </label>
      <InputText
        id="base_url"
        v-model="mainConfig.base_url"
        placeholder="https://example.com"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="authTypes">
        {{ __("messages.auth_type") }}
      </label>
      <Dropdown
        id="authTypes"
        v-model="mainConfig.auth_type"
        :options="authTypes"
        optionLabel="label"
        optionValue="code"
        placeholder="Select authenticate type"
        showClear
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid" v-if="mainConfig.auth_type">
    <div class="field col-12 md:col-6">
      <label for="username">
        {{ __("messages.username") }}
      </label>
      <InputText
        id="username"
        v-model="mainConfig.username"
        placeholder="username"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid" v-if="mainConfig.auth_type">
    <div class="field col-12 md:col-6">
      <label for="password">
        {{ __("messages.password") }}
      </label>
      <InputText
        id="password"
        v-model="mainConfig.password"
        placeholder="****"
      />
    </div>
  </div>
</template>

<script>
import { computed, ref } from "vue";
export default {
  props: {
    mainConfig: Object,
  },
  setup(props) {
    const authTypes = ref([
      { label: "Basic Authenticate", code: "basic_auth" },
    ]);
    return { authTypes };
  },
};
</script>

<style>
</style>