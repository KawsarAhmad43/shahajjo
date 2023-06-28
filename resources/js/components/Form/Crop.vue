<template>
  <div>
    <cropper
      ref="cropper"
      src="https://images.pexels.com/photos/580012/pexels-photo-580012.jpeg"
      :stencil-props="aspectRatio"
      :default-size="defaultSize"
    />
    <button type="button" @click.prevent="crop">Crop</button>
    <img :src="image" alt="" />
  </div>
</template>
<script>
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

export default {
  components: {
    Cropper,
  },
  data() {
    return {
      image: "",
    };
  },

  methods: {
    crop() {
      const { coordinates, canvas } = this.$refs.cropper.getResult();
      this.coordinates = coordinates;
      this.image = canvas.toDataURL();
    },
  },
};
</script>
<style >
.vue-advanced-cropper {
  height: 350px !important;
  background: #ddd !important;
}
</style>