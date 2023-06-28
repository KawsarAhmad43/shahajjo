<template>
  <div :class="getClass()" class="mb-3">
    <label class="form-label">
      <slot name="title"> {{ title.replaceAll("_", " ") }} </slot>
      <sup v-if="req" class="text-danger">*</sup>
    </label>

    <div class="d-flex justify-content-between">
      <div v-for="(item, key) in list" :key="key" class="form-check">
        <input
          class="form-check-input shadow-none"
          type="radio"
          :id="'radio' + key"
          @input="$emit('update:modelValue', $event.target.value)"
          :value="item.value"
          :name="fieldName"
          :checked="modelValue == item.value"
        />
        <label class="form-check-label" :for="'radio' + key">
          {{ item.title }}
        </label>
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
    list: {
      type: [Array, Object],
    },
    field: {
      type: String,
    },
    col: {
      type: String,
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
      let col = this.col ? this.col : 2;
      let className = "col-lg-" + col + " ";
      return className;
    },
  },
};
</script>
