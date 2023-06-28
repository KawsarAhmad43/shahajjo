<template>
  <div v-if="loading" class="loader">
    <h1>Hello</h1>
  </div>
  <router-view v-else />
</template>

<script>
export default {
  data() {
    return {
      loading: false,
    };
  },
  created() {
    this.$router.beforeEach((to, from, next) => {
      this.loading = true;
      next();
    });

    this.$router.afterEach(() => {
      this.loading = false;
    });
  },
};
</script>

<style>
.loader {
  /* Loader styles */
}
</style>
