<template>
  <view-page></view-page>
</template>

<script>
// define model name
const model = "video";

export default {
  data() {
    return {
      model: model,
      data: {},
      fields: ["title", "thumbnail", "url", "sorting", "status", "created_at"],
      belongs_to: {
        data: {},
        fields: ["name"],
        model: "album",
      },
    };
  },
  methods: {
    getVideo() {
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
    this.getVideo();
  },
};
</script>
