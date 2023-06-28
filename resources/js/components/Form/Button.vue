<template>
  <button
    type="submit"
    :disabled="$root.submit ? true : false"
    class="btn btn2 shadow-none"
    :class="btnTitle == 'Submit' ? 'btn-primary' : 'btn-success'"
  >
    <span v-if="$root.submit">
      <i class="fa fa-spinner fa-spin"></i>
      <span v-if="process">{{ process }}...</span>
      <span v-else> processing...</span>
    </span>
    <span v-else> {{ btnTitle }}</span>
  </button>
</template>

<script>
export default {
  props: ["title", "process"],
  data() {
    return {
      type: "",
      btnTitle: this.title,
    };
  },
  mounted() {
    let split = this.$route.name.split(".");
    if (split.length == 2) {
      if (this.title == "Submit" && split[1] == "edit") {
        this.btnTitle = "Update";
      }
    }
  },
};
</script>
