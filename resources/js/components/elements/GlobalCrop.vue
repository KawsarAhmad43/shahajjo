
<template>
  <!-- Consultency Action Modal -->
  <div
    class="modal fade"
    id="showCropModal"
    tabindex="-1"
    aria-labelledby="deleteModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-black" id="deleteModalLabel">
            Upload Image
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <h6 class="mb-3 text-black">Crop</h6>

          <cropper
            ref="cropper"
            :src="image"
            :stencil-props="aspectRatio"
            :default-size="defaultSize"
          ></cropper>
          <div class="col-12 text-center">
            <hr />
            <span class="btn btn-success btn-lg text-white" @click="cropImage">
              Crop
            </span>
          </div>
        </div>
      </div>
    </div>
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
      this.$emit("update:modelValue", result.canvas.toDataURL("image/jpeg"));
      this.$toast("Image Cropped Successfully", "success");
      $("#showCropModal").modal("hide");
      //   this.$parent.data[this.field] = result.canvas.toDataURL("image/jpeg");
      //   $("#showCropModal").modal("hide");
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
