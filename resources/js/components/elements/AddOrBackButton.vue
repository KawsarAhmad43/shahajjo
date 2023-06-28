<template>
  <div class="col-sm-5 col-lg-3 col-xxl-2 ms-auto mb-3">
    <router-link
      class="add-btn d-flex ms-auto"
      v-if="$root.checkPermission(route)"
      :to="{
        name: route,
        query: { page: icon != 'plus' ? $route.query.page : '' },
      }"
    >
      <div v-if="icon == 'plus'">
        <div class="btn-front">
          <i :class="'fas fa-' + icon" aria-hidden="true"></i> Add
          {{ $filter.capitalize(title ? title : portion) }}
        </div>
        <div class="btn-back">
          <i :class="'fas fa-' + icon" aria-hidden="true"></i> Add
          {{ $filter.capitalize(title ? title : portion) }}
        </div>
      </div>
      <div v-else>
        <div class="btn-front">
          <i :class="'fas fa-' + icon" aria-hidden="true"></i><b>Back</b>
        </div>
        <div class="btn-back">
          <i :class="'fas fa-' + icon" aria-hidden="true"></i><b>Back</b>
        </div>
      </div>
    </router-link>
  </div>
</template>

<script>
export default {
  props: ["route", "icon", "portion", "title", "extraButtons"],
};
</script>
