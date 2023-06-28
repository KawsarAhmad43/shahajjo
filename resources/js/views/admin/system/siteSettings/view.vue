<template>
  <view-page></view-page>
</template>

<script>
// define model name
const model = "siteSetting";

export default {
  data() {
    return {
      model: model,
      data: {},
    };
  },
  async created() {
    this.setBreadcrumbs(this.model, "view");
    await this.get_data(`${this.model}/${this.$route.params.id}`);
  },
};
</script>