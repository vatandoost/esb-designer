<template>
  <div class="grid">
    <div class="col-12 p-2">
      <rest-config
        :mainConfig="mainConfig"
        v-if="form.type == 'rest'"
      />
      <soap-config
        :mainConfig="mainConfig"
        v-if="form.type == 'soap'"
      />
      <email-config
        :mainConfig="mainConfig"
        v-if="form.type == 'email'"
      />
    </div>

    <div class="col-12 p-2">
      <Button
        :label="__('messages.save_configs')"
        class="p-button-success"
        icon="pi pi-save"
        @click="submit"
      />
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import RestConfig from "./Configs/RestConfig.vue";
import SoapConfig from './Configs/SoapConfig.vue';
import EmailConfig from './Configs/EmailConfig.vue';

export default {
  components: {
    RestConfig,
    SoapConfig,
    EmailConfig,
  },
  props: {
    form: Object,
    types: Array,
  },
  setup(props, { emit }) {
    const mainConfig = ref(Object.assign({}, props.form.config));

    async function submit() {
      emit("submit", mainConfig.value);
    }

    return {
      mainConfig,
      submit,
    };
  },
};
</script>

<style>
</style>