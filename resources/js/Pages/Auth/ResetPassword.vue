<template>
  <Head title="Log in" />
  <ValidationErrors class="p-mb-4 w-full text-center" />

  <div v-if="status" class="p-mb-4 font-medium text-sm text-green-600">
    {{ status }}
  </div>

  <form @submit.prevent="submit">
    <div class="flex align-items-center justify-content-center mt-5">
      <div class="surface-card p-4 shadow-2 border-round w-full lg:w-6">
        <div class="text-center mb-5">
          <img
            src="../../assets/logo_transparent.png"
            alt="Image"
            height="100"
            class="mb-1"
          />
          <div class="text-900 text-3xl font-medium mb-3">Reset Password</div>
        </div>

        <div>
          <label for="email1" class="block text-900 font-medium mb-2">
            Email
          </label>
          <InputText
            id="email1"
            name="email"
            type="email"
            class="w-full mb-3"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />

          <label for="password" class="block text-900 font-medium mb-2">
            Password
          </label>
          <InputText
            id="password"
            type="password"
            v-model="form.password"
            required
            autocomplete="new-password"
            class="w-full mb-3"
          />
          <label
            for="password_confirmation"
            class="block text-900 font-medium mb-2"
          >
            Confirm Password
          </label>
          <InputText
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
            class="w-full mb-3"
          />

          <Button
            label="Reset Password"
            icon="pi pi-user"
            class="w-full"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            type="submit"
          ></Button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import GuestLayout from "@/Layouts/Guest.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
  layout: GuestLayout,

  components: {
    ValidationErrors,
    Head,
    Link,
  },

  props: {
    email: String,
    token: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: "",
        password_confirmation: "",
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("password.update"), {
        onFinish: () => this.form.reset("password", "password_confirmation"),
      });
    },
  },
};
</script>