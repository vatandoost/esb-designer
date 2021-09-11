<template>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="host">
        {{ __("messages.host") }}
      </label>
      <InputText
        id="host"
        v-model="mainConfig.host"
        placeholder="mail.example.com"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="port">
        {{ __("messages.port") }}
      </label>
      <InputNumber
        id="port"
        v-model="mainConfig.port"
        placeholder="587"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid">
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
  <div class="p-fluid formgrid grid" >
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
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="encryption">
        {{ __("messages.encryption") }}
      </label>
      <Dropdown
        id="encryption"
        v-model="mainConfig.encryption"
        :options="encryptions"
        optionLabel="label"
        optionValue="code"
        placeholder="Select encryption type"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="from_address">
        {{ __("messages.from_address") }}
      </label>
      <InputText
        id="from_address"
        v-model="mainConfig.from_address"
        placeholder="mail@example.com"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="from_name">
        {{ __("messages.from_name") }}
      </label>
      <InputText
        id="from_name"
        v-model="mainConfig.from_name"
        placeholder="example name"
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
    const encryptions = ref([
      { label: "TLS", code: "tls" },
      { label: "SSL", code: "ssl" },
    ]);
    return { encryptions };
  },
};
</script>

<style>
</style>