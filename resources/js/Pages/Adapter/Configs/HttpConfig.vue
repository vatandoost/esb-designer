<template>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="method">
        {{ __("messages.method") }}
      </label>
      <Dropdown
        id="method"
        v-model="mainConfig.method"
        :options="methods"
        optionLabel="label"
        optionValue="code"
        placeholder="Select a method"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="requestTypes">
        {{ __("messages.request_type") }}
      </label>
      <Dropdown
        id="requestTypes"
        v-model="mainConfig.request_type"
        :options="requestTypes"
        optionLabel="label"
        optionValue="code"
        placeholder="Select a type"
      />
    </div>
  </div>
  <div class="p-fluid formgrid grid">
    <div class="field col-12 md:col-6">
      <label for="response_type">
        {{ __("messages.response_type") }}
      </label>
      <Dropdown
        id="response_type"
        v-model="mainConfig.response_type"
        :options="responseTypes"
        optionLabel="label"
        optionValue="code"
        placeholder="Select a type"
      />
    </div>
  </div>
</template>

<script>
import { computed } from 'vue';
export default {
  props: {
    mainConfig: Object,
    options: Object,
  },
  setup(props) {
    const methods = computed(() => {
      if (!props.options || !props.options.methods) {
        return [];
      }
      return props.options.methods;
    });
    const requestTypes = computed(() => {
      if (!props.options || !props.options.requestTypes) {
        return [];
      }
      return props.options.requestTypes;
    });
    const responseTypes = computed(() => {
      if (!props.options || !props.options.responseTypes) {
        return [];
      }
      return props.options.responseTypes;
    });
    return {
      methods,
      requestTypes,
      responseTypes,
    };
  },
};
</script>

<style>
</style>