<template>
  <div :class="getClass()" class="mb-3">
    <div class="">
      <label v-if="title" class="d-block w-100 mb-2 text-dark">
        <slot name="title"> {{ title.replaceAll("_", " ") }} </slot>
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
            class="fas fa-info-circle icon-color"
            data-bs-toggle="tooltip"
            data-bs-placement="left"
            :title="`Please Put ` + title.replaceAll('_', ' ') + ` Here`"
            ref="info"
          ></i>
        </span>
      </label>

      <slot></slot>
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
    col: {
      type: [String, Number],
    },
    req: {
      type: Boolean,
      default: false,
    },
  },

  inject: ["validate"],
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
      if (errorStatus && this.req) {
        $(".vs__dropdown-toggle").addClass("border-danger");
        return "position-absolute bg-danger text-white floating-tooltip text-center";
      } else if (this.field) {
        $(".vs__dropdown-toggle").removeClass("border-danger");
        $(".vs__dropdown-toggle").addClass("border-success");
        return "fas fa-circle-check text-success";
      }
    },
  },
  mounted() {
    $('[data-bs-toggle="tooltip"]').tooltip();
  },
};
</script>

<style>
.vs__dropdown-menu li {
  color: #555;
}
.vs__search:focus {
  color: #555 !important;
}
.vs__dropdown-option--highlight {
  color: #fff !important;
}
.vs__search,
.vs__search:focus {
  margin: 10px 0 0 !important;
}
.icon-color {
  color: rgb(119 126 221);
}
</style>