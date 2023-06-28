<template>
  <div :class="getClass()" class="mb-3">
    <label class="form-label">
      <slot name="title"> {{ title.replaceAll("_", " ") }} </slot>
      <sup v-if="req" class="text-danger">*</sup>
    </label>
    <div class="input-group position-relative">
      <textarea
        :type="type"
        @input="$emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        :class="errorClass()"
        :placeholder="title"
        :disabled="disabled"
        :readonly="readonly"
        :name="fieldName"
      ></textarea>
      <div class="validation-icon position-absolute">
        <i :class="getIcon()" aria-hidden="true"></i>
      </div>
    </div>

    <span v-if="validate.hasError(this.field)" class="input-message danger">
      {{ validate.firstError(this.field) }}
    </span>
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
        return "far fa-times-circle danger-icon";
      } else if (this.modelValue) {
        return "bi bi-check-lg success-icon";
      }
    },
    errorClass() {
      let className = "form-control shadow-none ";
      if (this.req) {
        if (this.validate.hasError(this.field)) {
          className += "danger";
        } else if (this.modelValue) {
          className += "success";
        }
      }
      return className;
    },
  },
};
</script>