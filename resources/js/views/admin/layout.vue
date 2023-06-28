<template>
  <section class="dashboard">
    <AppSidebar />
    <div class="main-content-body">
      <AppNav />
      <AppBreadcrumb />

      <!-- All Inner Page -->
      <router-view></router-view>
      <div class="content-part">
        <div v-if="$root.spinner" class="inner-content">
          <div
            class="global-form d-flex align-items-center justify-content-center"
            style="height: 450px"
          >
            <div class="loading-main">
              <div class="loading-body">
                <div>
                  <!-- <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div> -->
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <AppFooter />

      <ValidationMessage />
    </div>
  </section>
</template>

<script>
import AppNav from "./../../components/AppNav.vue";
import AppFooter from "./../../components/AppFooter.vue";
import AppSidebar from "./../../components/AppSidebar.vue";
import AppBreadcrumb from "./../../components/AppBreadcrumb.vue";
import ValidationMessage from "./../../components/elements/ValidationMessage.vue";

export default {
  name: "App",
  components: {
    AppNav,
    AppFooter,
    AppSidebar,
    AppBreadcrumb,
    ValidationMessage,
  },

  mounted() {
    $(window).on("load", function () {
      $(".loading-main").delay(1000).fadeOut(300);
    });
  },
};
</script>
