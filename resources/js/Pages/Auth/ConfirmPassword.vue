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
            src="../../assets/logo.png"
            alt="Image"
            height="50"
            class="mb-3"
          />
          <div class="text-900 text-3xl font-medium mb-3">Request Password</div>
          <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
          </div>
        </div>

        <div>
          <label for="password1" class="block text-900 font-medium mb-2"
            >Password</label
          >
          <InputText
            id="password"
            type="password"
            v-model="form.password"
            required
            autocomplete="current-password"
            class="w-full mb-3"
          />

          <Button
            label="Confirm"
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
        password: "",
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("password.confirm"), {
        onFinish: () => this.form.reset(),
      });
    },
  },
};
</script>