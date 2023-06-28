<template>
  <div class="form-row col-12 mt-3">
    <label class="col-12">
      <b-form-checkbox
        class="col-form-label-sm col-6"
        v-model="$parent.data.is_meta"
        name="is_meta"
        :value="1"
        :unchecked-value="0"
      >
        Meta Description
      </b-form-checkbox>
    </label>
    <div class="col-12" v-if="$parent.data.is_meta">
      <textarea
        name="meta"
        v-model="$parent.data.meta"
        class="form-control"
      ></textarea>
    </div>
  </div>
</template>