<template>
  <div class="card">
    <form @submit.prevent="$emit('submit')">
      <div class="p-fluid formgrid grid">
        <div class="field col-12 md:col-6">
          <label for="name">
            {{ __("validation.attributes.name") }}
          </label>
          <InputText id="name" type="text" v-model="form.name" />
        </div>
        <div class="field col-12 md:col-6">
          <label for="type">
            {{ __("validation.attributes.type") }}
          </label>
          <InputText id="typeValue" type="hidden" v-model="form.type" />
          <Dropdown
            id="type"
            v-model="type"
            :options="types"
            optionLabel="label"
            optionValue="type"
            placeholder="Select a type"
            @change="form.type = type"
          />
        </div>
        <div class="field col-12 md:col-6">
          <label for="host">
            {{ __("validation.attributes.host") }}
          </label>
          <InputText id="host" type="text" v-model="form.host" />
        </div>
        <div class="field col-12 md:col-6">
          <label for="port">
            {{ __("validation.attributes.port") }}
          </label>
          <InputText id="port" type="text" v-model="form.port" />
        </div>

        <div class="field col-12 md:col-6">
          <label for="db">
            {{ __("validation.attributes.db") }}
          </label>
          <InputText id="db" type="text" v-model="form.db" />
        </div>
        <div class="field col-12 md:col-6">
          <label for="schema">
            {{ __("validation.attributes.schema") }}
          </label>
          <InputText id="schema" type="text" v-model="form.schema" />
        </div>

        <div class="field col-12 md:col-6">
          <label for="username">
            {{ __("validation.attributes.username") }}
          </label>
          <InputText id="username" type="text" v-model="form.username" />
        </div>
        <div class="field col-12 md:col-6">
          <label for="password">
            {{ __("validation.attributes.password") }}
          </label>
          <InputText id="password" type="text" v-model="form.password" />
        </div>
      </div>
      <div>
        <Button
          type="submit"
          :label="__('messages.save')"
          class="p-button-success"
        />
      </div>
    </form>
  </div>
</template>

<script>
import { ref } from "vue";
export default {
  props: {
    form: Object,
    types: Array,
  },
  setup(props) {
    const type = ref(props.form.type);
    return { type };
  },
};
</script>

<style>
</style>