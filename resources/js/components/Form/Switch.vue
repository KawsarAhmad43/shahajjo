<template>
  <div :class="getClass()" class="mb-3">
    <label class="form-label">
      <slot name="title"> {{ title.replaceAll("_", " ") }} </slot>
      <sup v-if="req" class="text-danger">*</sup>
    </label>

    {{ modelValue }}

    <div class="d-flex justify-content-between">
      <div class="form-check form-switch">
        <!-- <input
          class="form-check-input shadow-none"
          type="checkbox"
          :id="'checkbox' + key"
          @input="$emit('update:changeSwitch', $event.target.value)"
          :name="fieldName"
        /> -->
        <input
          class="form-check-input"
          type="checkbox"
          checked
          v-model="switchData"
          @click="changeSwitch"
        />
        <label class="form-check-label" :for="'checkbox' + key">
          {{ modelValue }}
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

  data() {
    return {
      switchData: null,
    };
  },

  changeSwitch() {
    console.log("ok");
    this.$emit("update", this.switchData);
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
