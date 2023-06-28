<template>
  <view-page></view-page>
</template>

<script>
// define model name
const model = "photo";

export default {
  data() {
    return {
      model: model,
      data: {},
      fields: ["title", "created_at"],
      belongs_to: {
        data: {},
        fields: ["name"],
        model: "album",
      },
    };
  },

  methods: {
    getPhoto() {
      axios.get(`${this.model}/${this.$route.params.id}`).then((res) => {
        this.data = res.data;
        this.getAlbum(res.data.album_id);
      });
    },

    getAlbum(id) {
      axios.get(`album/${id}`).then((res) => {
        this.belongs_to.data = res.data;
      });
    },
  },

  created() {
    this.setBreadcrumbs(this.model, "view");
    this.getPhoto();
  },
};
</script>
