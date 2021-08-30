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
          <div class="text-900 text-3xl font-medium mb-3">Request Password</div>
          <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
          </div>
        </div>

        <div>
          <label for="email1" class="block text-900 font-medium mb-2"
            >Email</label
          >
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

          <Button
            label="Email Password Reset Link"
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
    canResetPassword: Boolean,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("password.email"));
    },
  },
};
</script>