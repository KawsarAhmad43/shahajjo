<template>
  <div>
    <b-modal id="canvas" title="Upload Photo" size="lg" no-close-on-backdrop>
      <cropper
        ref="cropper"
        :src="image"
        :stencil-props="aspectRatio"
        :default-size="defaultSize"
      ></cropper>
      <div class="col-12 text-center">
        <hr />
        <button class="btn btn-success btn-sm text-white" @click="cropImage">
          CROP IMAGE
        </button>
      </div>
    </b-modal>
  </div>
</template>
<script>
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";
export default {
  name: "CropImage",
  props: {
    image: String,
    aspectRatio: Object,
    width: Number,
    height: Number,
    field: String,
  },
  methods: {
    defaultSize() {
      return {
        width: this.width,
        height: this.height,
      };
    },
    cropImage() {
      const result = this.$refs.cropper.getResult();
      this.$parent.data[this.field] = result.canvas.toDataURL("image/jpeg");
      this.$bvModal.hide("canvas");
    },
  },
  components: {
    Cropper,
  },
};
</script>

<style >
.vue-advanced-cropper {
  height: 350px !important;
  background: #ddd !important;
}
</style>