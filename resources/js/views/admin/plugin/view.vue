<template>
  <view-page> </view-page>
</template>

<script>
// define model name
const model = "plugin";

export default {
  data() {
    return {
      model: model,
      data: {

      },
      fileColumns :[{ field: "zip_file", title: "Zip_file" },],
    };
  },
  created() {
    this.setBreadcrumbs(this.model, "view");
    this.get_data(`${this.model}/${this.$route.params.id}`);
  },
};
</script>