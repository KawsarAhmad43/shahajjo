<template>
  <div :class="getClass()">
    <div class="form-element">
      <label for="" class="d-block w-100">
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
            class="fas fa-info-circle"
            data-bs-toggle="tooltip"
            data-bs-placement="left"
            :title="`Please Put ` + title.replaceAll('_', ' ') + ` Here`"
            ref="info"
          ></i>
        </span>
      </label>
      <input
        :type="type"
        @input="$emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        :class="errorClass()"
        :placeholder="placeholder ? placeholder : title.replaceAll('_', ' ')"
        :disabled="disabled"
        :readonly="readonly"
        :name="fieldName"
      />
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
      type: String,
    },
    req: {
      type: Boolean,
      default: false,
    },
    placeholder: {
      type: String,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    readonly: {
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
        return "position-absolute bg-danger text-white floating-tooltip text-center";
      } else if (this.modelValue) {
        return "fas fa-circle-check text-success";
      }
    },

    errorClass() {
      let className = "form-control form-control-sm shadow-none ";
      if (this.req) {
        if (this.validate.hasError(this.field)) {
          className += "border-danger";
        } else if (this.modelValue) {
          className += "border-success";
        }
      }
      return className;
    },
  },
  mounted() {
    $('[data-bs-toggle="tooltip"]').tooltip();
  },
};
</script>