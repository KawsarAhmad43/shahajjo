<template>
  <ul class="submenu title">
    <li v-for="(child_menu, index) in child_menus" :key="index">
      <slot v-if="Object.keys(child_menu.child_menus).length > 0">
        <a href="javascript:void(0)" class="sub-menu-main">
          <em v-if="child_menu.icon" v-html="child_menu.icon"></em>
          <i v-else class="fa fa-circle-o text-aqua"></i>
          {{ child_menu.menu_name }}
          <span
            class="float-end"
            v-if="Object.keys(child_menu.child_menus).length > 0"
          >
            <i class="fa fa-chevron-right right p-0"></i>
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
          v-if="$root.checkPermission(child_menu.route_name)"
          :to="{
            name: child_menu.route_name,
            params: { slug: child_menu.params },
          }"
        >
          <em v-if="child_menu.icon" v-html="child_menu.icon"></em>
          <i v-else class="fa fa-circle-o text-aqua"></i>
          <span>{{ child_menu.menu_name }}</span>
        </router-link>
      </slot>
    </li>
  </ul>
</template>

<script>
export default {
  name: "AppSidebarRecursive",
  components: {
    RecursiveChildMenu: () => import("./AppSidebarRecursive.vue"),
  },
  props: ["child_menus", "root_menu"],
};
</script>