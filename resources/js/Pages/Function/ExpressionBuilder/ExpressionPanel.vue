<template>
  <h3>Expression</h3>
  <v-ace-editor
    v-model:value="content"
    @init="editorInit"
    lang="javascript"
    theme="chrome"
    style="height: 80%"
  />
</template>

<script>
import { VAceEditor } from "vue3-ace-editor";
import "ace-builds/src-noconflict/mode-javascript";
import "ace-builds/src-noconflict/theme-chrome";
import { ref } from 'vue';

export default {
  components: {
    VAceEditor,
  },
  setup(props) {
    function editorInit() {}
    const content = ref('alert("hi")');
    return { content, editorInit };
  },
};
</script>

<style>
</style>