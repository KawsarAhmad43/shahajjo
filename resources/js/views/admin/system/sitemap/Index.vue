<template>
  <div class="content-part">
    <div class="inner-content" v-if="!$root.spinner">
      <div class="row global-form">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Site Map</h3>
            </div>
            <div class="box-body">
              <ul v-if="$root.menus">
                <slot v-for="(root_menu, index) in $root.menus">
                  <!-- ===================CHILDREN MENU=================== -->
                  <slot v-if="root_menu.child_menus">
                    <li :key="index">
                      <a href="javascript:void(0)" style="color: black">
                        <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                        <span>{{ root_menu.menu_name }}</span>
                        <span class="pull-right-container">
                          <!-- <i class="fa fa-angle-left pull-right"></i> -->
                        </span>
                      </a>
                      <SiteMapMenu
                        style="margin-left: 30px"
                        :key="index + 'A'"
                        :root_menu="root_menu.menu_name"
                        :child_menus="root_menu.child_menus"
                      />
                    </li>
                  </slot>
                  <!-- ===================CHILDREN MENU=================== -->

                  <slot v-else>
                    <li :key="index" v-if="root_menu.route_name">
                      <!-- MENU  WITH PARAMS-->
                      <router-link
                        v-if="root_menu.params"
                        :to="{
                          name: root_menu.route_name,
                          params: { slug: root_menu.params },
                        }"
                      >
                        <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                        <span>{{ root_menu.menu_name }}</span>
                      </router-link>

                      <!-- SINGLE MENU -->
                      <router-link v-else :to="{ name: root_menu.route_name }">
                        <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                        <span>{{ root_menu.menu_name }}</span>
                      </router-link>
                    </li>
                  </slot>
                </slot>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SiteMapMenu from "./SiteMapMenu";
const breadcrumb = [{ route: "admin.sitemap", title: "Site Map" }];
export default {
  components: { SiteMapMenu },
  data() {
    return {
      menus: [],
    };
  },
  methods: {},
  async created() {
    this.setBreadcrumbs("sitemap", "index");
    var m = await axios.get("sitemap-data");
    this.menus = m.data;
    console.log(this.menus);
  },
};

// define model name
const model = "role";
// import { TreeView } from "@grapoza/vue-tree"

// export default {
//     components: {
//         TreeView
//     },
//     data() {
//         return {
//             model: model,
//             data: {},
//             dataModel: [
//                 {
//                     id: "numberOrString",
//                     label: "Root Node",
//                     children: [
//                         { id: 1, label: "Child Node" },
//                         { id: "node2", label: "Second Child" }
//                     ]
//                 }
//             ]
//         };
//     },
//     async created() {
//         this.setBreadcrumbs("sitemap", "index");
//         var m = await axios.get('sitemap-data');
//         this.data = m.data;
//         console.log(m.data);
//     },
// };
</script>