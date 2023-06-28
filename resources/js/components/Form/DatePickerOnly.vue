<template>
  <input
    :id="id"
    type="text"
    :name="name"
    :value="modelValue"
    :placeholder="placeholder"
    :class="!readonly ? 'date' : ''"
    class="form-control form-control-sm date-input"
    autocomplete="off"
  />
</template>

<script>
import "../../assets/datepicker/jquery-ui.css";
import "../../assets/datepicker/jquery-ui.js";

export default {
  props: {
    id: { type: String },
    modelValue: { type: String, default: "" },
    title: { type: String, default: "" },
    col: { type: [String, Number], default: "3" },
    req: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    readonly: { type: Boolean, default: false },
    dateFormat: { type: String, default: "yy-mm-dd" },
    changeMonth: { type: Boolean, default: true },
    changeYear: { type: Boolean, default: true },
    yearRange: { type: String, default: "-100:+0" },
    placeholder: { type: String, default: "Select Date" },
    name: { type: String, default: "" },
    successBorder: { type: Boolean, default: true },
  },

  watch: {
    value: {
      immediate: true,
      handler() {
        if (this.disabled) {
          return this.$emit("update:modelValue", "");
        }
      },
    },
  },

  mounted() {
    $(() => {
      $(`#${this.id}`).datepicker({
        showOn: "both",
        dateFormat: this.dateFormat,
        changeMonth: this.changeMonth,
        changeYear: this.changeYear,
        yearRange: this.yearRange,
        onSelect: (date) => this.$emit("update:modelValue", date),
      });
    });
  },

  methods: {
    getClass() {
      let col = this.col ? this.col : 3;
      let className = "col-lg-" + col + " ";
      return className;
    },
  },
};
</script>

<style lang="scss" scoped>
.date-input,
.date-input:disabled {
  background: rgb(233 236 239);
  opacity: 1;
}
.date {
  background: #fff;
}
</style>
