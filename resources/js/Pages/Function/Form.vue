<template>
  <div class="card">
    <TabView>
      <TabPanel :header="__('messages.details')">
        <Detail :item="item" :types="types" :namespaces="namespaces" />
      </TabPanel>
      <TabPanel :header="__('messages.input_parameters')">
        input_parameters I
      </TabPanel>
      <TabPanel :header="__('messages.output_parameters')">
        output_parameters I
      </TabPanel>
      <TabPanel :header="__('messages.definition')"> definition I </TabPanel>
    </TabView>
  </div>
</template>

<script>
import { ref } from "vue";
import Detail from "./Forms/Detail.vue";

export default {
  components: {
    Detail,
  },
  props: {
    item: Object,
    types: Array,
    namespaces: Array,
  },
  setup(props) {},
};
</script>

<style>
</style>