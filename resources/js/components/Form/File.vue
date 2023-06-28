<template>
  <div :class="getClass()">
    <div class="form-element d-flex flex-wrap">
      <label for="" class="d-block w-100">
        <slot name="title">
          {{ title.replaceAll("_", " ") }}
          <span style="font-size: 11px; color: green">{{
            this.crop ? "( Crop Enable )" : ""
          }}</span></slot
        >
        <sup v-if="req" class="text-danger">*</sup>
        <span class="ms-1 position-relative">
          <i
            :class="
              validate.firstError(this.field)
                ? 'fa-solid fa-circle-question text-danger'
                : ''
            "
          ></i>
          <small :class="getIcon()">{{
            validate.firstError(this.field)
          }}</small>
        </span>

        <span class="float-end">
          <i
            class="fas fa-info-circle"
            data-bs-toggle="tooltip"
            data-bs-placement="left"
            :title="`Please Put ` + title.replaceAll('_', ' ') + ` Here`"
            ref="info"
          ></i>
        </span>
      </label>
      <div class="image-box position-relative">
        <img
          :src="showImage().includes('pdf') ? this.attach : showImage()"
          alt=""
          class="w-100"
        />
        <div class="overlay position-absolute top-0 start-0 w-100 h-100">
          <i
            class="fa-solid fa-circle-xmark position-absolute close"
            @click.prevent="removeImage()"
          ></i>
        </div>
      </div>

      <div class="upload-box" v-if="crop">
        <input
          :name="fieldName"
          type="file"
          :accept="mime"
          class="d-none"
          v-on:change="showCropImage($event, field, fileClassName)"
          :id="fileClassName"
        />
        <label
          class="attached"
          :class="modelValue ? '' : errorClass()"
          :for="fileClassName"
          ><i class="fa-solid fa-cloud-arrow-up me-3"></i> Upload
          {{ mime == ".pdf" ? "File" : "Image" }}</label
        >
      </div>
      <div class="upload-box" v-else>
        <input
          :name="fieldName"
          type="file"
          :accept="mime"
          class="d-none"
          v-on:change="onFileChange(fieldName, fileClassName)"
          :id="fileClassName"
        />
        <label :class="modelValue ? '' : errorClass()" :for="fileClassName"
          ><i class="fa-solid fa-cloud-arrow-up me-3"></i>Upload
          {{ mime == ".pdf" ? "File" : "Image" }}</label
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: [String, Number],
    },
    title: {
      type: String,
    },
    field: {
      type: String,
    },
    type: {
      type: String,
      default: "text",
    },
    mime: {
      type: String,
      default: "image/*",
    },
    col: {
      type: String,
    },
    req: {
      type: Boolean,
      default: false,
    },
    fileClassName: {
      type: String,
    },
    crop: {
      type: Boolean,
      default: false,
    },
    showCrop: {
      type: Boolean,
      default: false,
    },
  },

  inject: ["validate", "data", "image"],

  computed: {
    fieldName() {
      return this.field.split(".").pop();
    },
  },

  methods: {
    getClass() {
      let col = this.col ? this.col : 3;
      let className = "col-lg-" + col + " ";
      return className;
    },
    getIcon() {
      let errorStatus = this.validate.hasError(this.field);
      if (errorStatus) {
        return "position-absolute bg-danger text-white floating-tooltip text-center";
      } else if (this.modelValue) {
        return "fas fa-circle-check text-success";
      }
    },
    errorClass() {
      let className = "";
      if (this.req) {
        if (this.validate.hasError(this.field)) {
          className += "border-danger";
        } else if (this.modelValue) {
          className += "border-success";
        }
      }
      return className;
    },
    removeImage() {
      this.data()[this.fieldName] = "";
      this.image[this.fieldName] = "";
    },
    onFileChange(field, fileClass) {
      let pdf = this.mime == ".pdf" ? "pdf" : null;
      let file = document.getElementById(fileClass).files[0];

      if (this.showCrop) {
        var type = file.type;
        if (
          type == "image/jpeg" ||
          type == "image/jpg" ||
          type == "image/png"
        ) {
          $("#showCropModal").modal("show");
        } else {
          this.$toast("Please provide a valid image", "error");
          return;
        }
      }

      this.showImageGlobal(file, field, pdf);
    },
    showImage() {
      if (this.image[this.fieldName]) {
        return this.image[this.fieldName];
      } else if (this.data()[this.fieldName]) {
        return this.data()[this.fieldName];
      }
      return this.noimage;
    },
    showCropImage(event, field, fileClass = null) {
      $(".attached").html("File attached");
      // var input = event.target;
      // if (input.files && input.files[0]) {
      //   var reader = new FileReader();
      //   reader.onload = (e) => {
      //     this.image[this.fieldName] = e.target.result;
      //   };
      //   reader.readAsDataURL(input.files[0]);
      // }
    },
    showCropModal() {
      $("#consultancyModal").modal("show");
    },
  },
};
</script>
