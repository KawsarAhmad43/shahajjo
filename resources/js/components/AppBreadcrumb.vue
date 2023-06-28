<template>
  <div class="bread-crumb-part">
    <div class="row">
      <div class="col-lg-6 small-device-dash">
        <div class="left-title">
          <h3 style="text-transform: capitalize" v-if="breadcrumbs[0]">
            {{ breadcrumbs[Object.keys(breadcrumbs).length - 1]["title"] }}
          </h3>
        </div>
      </div>
      <div class="col-lg-6 small-device-breadcrumb">
        <div class="right-info text-end">
          <ul>
            <li>
              <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
            </li>
            <li
              v-for="(menu, index1) in breadcrumbs"
              :key="index1"
              :class="menu.route == $route.name ? 'active' : ''"
              style="text-transform: capitalize"
            >
              <a v-if="Object.keys(breadcrumbs).length == index1 + 1">
                {{ menu.title }}
              </a>
              <router-link
                v-else-if="menu.slug"
                :to="{
                  name: menu.route,
                  params: { slug: menu.slug },
                }"
              >
                {{ menu.title }}
              </router-link>
              <router-link v-else :to="{ name: menu.route }">
                {{ menu.title }}
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>