<template>
  <Head title="Dashboard" />

  <App :breadcrumbs="[{ label: __('messages.dashboard')}]">
    <div class="grid fluid dashboard">
      <div class="col-12 lg:col-6">
        <div class="card summary">
          <span class="title">{{ __("messages.users") }}</span>
          <span class="detail">{{ __("messages.number_of_users") }}</span>
          <span class="count visitors">{{ usersCount }}</span>
        </div>
      </div>
      <div class="col-12 lg:col-6">
        <div class="card summary">
          <span class="title">{{ __("messages.projects") }}</span>
          <span class="detail">{{ __("messages.number_of_projects") }}</span>
          <span class="count purchases">{{ projectsCount }}</span>
        </div>
      </div>
    </div>
  </App>
</template>

<script>
import App from "@/Layouts/App/App.vue";
import Button from "primevue/button";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  props: {
    projectsCount: Number,
    usersCount: Number,
  },
  components: {
    App,
    Head,
    Button,
  },
  setup(props) {},
};
</script>
