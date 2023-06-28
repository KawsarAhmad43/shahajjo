<template>
  <div :class="getClass()" class="mb-3">
    <label class="form-label">
      <slot name="title"> {{ title }} </slot>
      <sup v-if="req" class="text-danger">*</sup>
    </label>

    <div class="d-flex justify-content-between">
      <div v-for="(item, key) in list" :key="key" class="form-check">
        <input
          class="form-check-input shadow-none"
          type="checkbox"
          :id="'checkbox' + key"
          :value="item.value"
          v-model="model"
          :name="fieldName"
        />
        <label class="form-check-label" :for="'checkbox' + key">
          {{ item.title }}
        </label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: [String, Number, Array],
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
    model: {
      get() {
        return this.modelValue;
      },
      set(newValue) {
        this.$emit("update:modelValue", newValue);
      },
    },
  },
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
