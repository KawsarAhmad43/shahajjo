<template>
  <ckeditor
    :editor="editor"
    @input="onChange"
    :config="editorConfig"
    :model-value="modelValue"
  ></ckeditor>
</template>

<script>
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  name: "CKEditor",

  props: {
    editorConfig: {
      type: Object,
      default: {},
    },
    modelValue: {
      type: String,
      default: "",
    },
  },

  components: {
    ckeditor: CKEditor.component,
  },

  inject: ["validate"],

  data() {
    return {
      editor: ClassicEditor,
    };
  },

  methods: {
    onChange(value) {
      this.$emit("update:modelValue", value);
    },
  },
};
</script>

<style lang="scss">
.ck-editor__editable {
  min-height: 300px;
}
</style>