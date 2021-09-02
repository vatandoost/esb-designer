<template>
  <Head :title="__('messages.users') + ' > ' + __('messages.update')" />

  <App
    :breadcrumbs="[
      { label: __('messages.users'), to: '/user' },
      { label: __('messages.update') },
    ]"
  >
    <div class="card">
      <form @submit.prevent="submit">
        <div class="p-fluid formgrid grid">
          <div class="field col-12 md:col-6">
            <label for="name">
              {{ __("validation.attributes.name") }}
            </label>
            <InputText
              id="name"
              v-model="form.name"
              :class="{ 'p-invalid': !!errors.name }"
            />
            <small class="p-error">{{ errors.name }}</small>
          </div>
        </div>
        <div class="p-fluid formgrid grid">
          <div class="field col-12 md:col-6">
            <label for="email">
              {{ __("validation.attributes.email") }}
            </label>
            <InputText
              id="email"
              type="email"
              v-model="form.email"
              :class="{ 'p-invalid': !!errors.email }"
            />
            <small class="p-error">{{ errors.email }}</small>
          </div>
        </div>
        <div class="p-fluid formgrid grid">
          <div class="field col-12 md:col-6">
            <label for="password">
              {{ __("validation.attributes.password") }}
            </label>
            <Password
              v-model="form.password"
              :class="{ 'p-invalid': !!errors.password }"
              toggleMask
            />
            <small class="p-error">{{ errors.password }}</small>
          </div>
        </div>
        <div class="p-fluid formgrid grid">
          <div class="field col-12 md:col-6">
            <label for="password_confirmation">
              {{ __("validation.attributes.password_confirmation") }}
            </label>
            <Password
              v-model="form.password_confirmation"
              :class="{ 'p-invalid': !!errors.password_confirmation }"
              toggleMask
            />
            <small class="p-error">{{ errors.password_confirmation }}</small>
          </div>
        </div>
        <div class="field col-12 md:col-10">
          <label for="is_admin">
            {{ __("validation.attributes.is_admin") }}
          </label>
          <br />
          <InputSwitch id="is_admin" v-model="form.is_admin" />
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
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { reactive } from "vue";
import * as yup from "yup";

export default {
  components: {
    App,
    Head,
    Link,
  },
  props: {
    item: Object,
  },
  setup(props) {
    const errors = reactive({});
    const schema = yup.object().shape({
      name: yup.string().required().required(),
      email: yup.string().email().required(),
      password: yup.string(),
      password_confirmation: yup.string(),
      is_admin: yup.boolean(),
    });
    const form = reactive({
      name: props.item.name,
      email: props.item.email,
      password: "",
      password_confirmation: "",
      is_admin: props.item.is_admin,
    });

    async function submit() {
      try {
        schema.validateSync(form, { abortEarly: false });
        Inertia.post(route("user.update", { user: props.item.id }), form);
      } catch (err) {
        if (err.inner) {
          for (const er in errors) {
            errors[er] = "";
          }
          for (const error of err.inner) {
            errors[error.path] = error.message;
          }
        }
      }
    }

    return { form, submit, errors };
  },
};
</script>