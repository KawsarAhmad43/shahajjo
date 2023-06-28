<template>
  <ul>
    <li v-for="(child_menu, index) in child_menus" :key="index">
      <slot v-if="Object.keys(child_menu.child_menus).length > 0">
        <a href="javascript:void(0)">
          <em v-if="child_menu.icon" v-html="child_menu.icon"></em>
          <i v-else class="fa fa-circle-o text-aqua"></i>
          <span>{{ child_menu.menu_name }}</span>
          <span
            class="pull-right-container"
            v-if="Object.keys(child_menu.child_menus).length > 0"
          >
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <!-- ===================Children Menu=================== -->
        <recursive-child-menu
          :root_menu="child_menu.menu_name"
          :child_menus="child_menu.child_menus"
        >
        </recursive-child-menu>
        <!-- ===================Children Menu=================== -->
      </slot>
      <slot v-else>
        <router-link
          :to="{
            name: child_menu.route_name,
            params: { slug: child_menu.params },
          }"
        >
          <em v-if="child_menu.icon" v-html="child_menu.icon"></em>
          <i v-else class="fa fa-circle-o text-aqua"></i>
          <span>{{ child_menu.menu_name }}</span>
          <span
            class="pull-right-container"
            v-if="Object.keys(child_menu.child_menus).length > 0"
          >
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </router-link>
      </slot>
    </li>
  </ul>
</template>

<script>
export default {
  name: "RecursiveMenu",
  components: {
    RecursiveChildMenu: () => import("./SiteMapMenu.vue"),
  },
  props: ["child_menus", "root_menu"],
};
</script>