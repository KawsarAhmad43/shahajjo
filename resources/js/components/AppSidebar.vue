<template>
  <div class="toggle-overlay d-block d-lg-none"></div>
  <div class="navigation-body shadow">
    <div class="close-mobile-menu d-block d-lg-none">
      <i class="bi bi-arrow-left"></i>
    </div>
    <div class="logo">
      <router-link :to="{ name: 'dashboard' }">
        <img
          v-if="site && site.logo"
          :src="site.logo"
          class="main-logo bg-white"
          alt="logo"
          width="120"
        />
        <img
          v-if="site && site.logo_small"
          :src="site.logo_small"
          class="mini-logo d-none bg-white"
          alt="mini-logo"
          width="40"
        />
        <img
          v-else-if="site && site && site.logo"
          :src="site.logo"
          class="mini-logo d-none"
          alt="mini-logo"
          width="40"
        />
      </router-link>
    </div>
    <div class="navigation" id="my-scrollbar" data-scrollbar>
      <div class="top-heading title">
        <h4>Navigation</h4>
      </div>
      <div class="main-menus">
        <ul
          v-if="menus && Object.keys(menus).length > 0"
          id="accordion"
          class="accordion"
        >
          <li>
            <router-link :to="{ name: 'dashboard' }">
              <span class="icon"><i class="fas fa-cog spin"></i></span>
              <span class="title"> Dashboard </span>
            </router-link>
          </li>

          <slot v-for="(root_menu, index) in menus">
            <!-- ===================CHILDREN MENU=================== -->
            <slot
              v-if="
                root_menu.child_menus &&
                Object.keys(root_menu.child_menus).length > 0
              "
            >
              <li :key="index" class="sub-menu">
                <div class="link">
                  <span class="icon">
                    <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                  </span>
                  <span class="title">
                    <span>{{ root_menu.menu_name }}</span>
                    <span class="arrow float-end">
                      <i class="fa fa-chevron-right right p-0"></i>
                    </span>
                  </span>
                </div>

                <RecursiveMenu
                  :key="index + 'A'"
                  :root_menu="root_menu.menu_name"
                  :child_menus="root_menu.child_menus"
                />
              </li>
            </slot>
            <!-- ===================CHILDREN MENU=================== -->

            <slot v-else>
              <li
                :key="index"
                v-if="
                  root_menu.route_name &&
                  $root.checkPermission(root_menu.route_name)
                "
              >
                <!-- MENU  WITH PARAMS-->
                <router-link
                  v-if="root_menu.params"
                  :to="{
                    name: root_menu.route_name,
                    params: { slug: root_menu.params },
                  }"
                >
                  <span class="icon">
                    <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                  </span>
                  <span class="title">
                    <span>{{ root_menu.menu_name }}</span>
                  </span>
                </router-link>

                <!-- SINGLE MENU -->
                <router-link v-else :to="{ name: root_menu.route_name }">
                  <span class="icon">
                    <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                  </span>
                  <span class="title">
                    <span>{{ root_menu.menu_name }}</span>
                  </span>
                </router-link>
              </li>
            </slot>
          </slot>
        </ul>
      </div>
    </div>

    <!-- collapsed navigation start -->
    <div class="collapsed-navigation d-none">
      <ul>
        <li>
          <a href="#">
            <i class="fas fa-cog spin"></i>
          </a>
          <div class="mini-dropdown-menu">
            <ul>
              <li class="menu-title">
                <router-link :to="{ name: 'dashboard' }" class="mini-dashboard">
                  Dashboard
                </router-link>
              </li>
            </ul>
          </div>
        </li>

        <slot v-for="(root_menu, index) in menus">
          <slot
            v-if="
              root_menu.child_menus &&
              Object.keys(root_menu.child_menus).length > 0
            "
          >
            <li :key="index">
              <a href="#">
                <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
              </a>
              <div class="mini-dropdown-menu">
                <RecursiveMenuCollasped
                  :key="index + 'A'"
                  :root_menu="root_menu.menu_name"
                  :child_menus="root_menu.child_menus"
                />
              </div>
            </li>
          </slot>
          <slot v-else>
            <li
              v-if="
                root_menu.route_name &&
                $root.checkPermission(root_menu.route_name)
              "
              :key="index + 1"
            >
              <a href="#">
                <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
              </a>
              <div class="mini-dropdown-menu">
                <ul>
                  <li class="menu-title">
                    <router-link
                      v-if="root_menu.params"
                      :to="{
                        name: root_menu.route_name,
                        params: { slug: root_menu.params },
                      }"
                      class="mini-dashboard"
                    >
                      {{ root_menu.menu_name }}
                    </router-link>
                    <router-link
                      v-else
                      :to="{ name: root_menu.route_name }"
                      class="mini-dashboard"
                    >
                      {{ root_menu.menu_name }}
                    </router-link>
                  </li>
                </ul>
              </div>
            </li>
          </slot>
        </slot>
      </ul>
    </div>

    <!-- collapsed navigation end-->
    <div class="branding text-center">
      <h6 class="full-brand">
        Developed By
        <a
          href="https://www.nogorsolutions.com/"
          target="_blank"
          class="d-block"
          >Nogor Solutions Limited</a
        >
      </h6>
      <div class="short-brand d-none">
        <img :src="`${asset}nogor-favicon.png`" alt="nogo-fevicon" />
      </div>
    </div>
  </div>
</template>

<script>
import RecursiveMenu from "./AppSidebarRecursive";
import RecursiveMenuCollasped from "./AppSidebarCollaspedRecursive";

export default {
  components: { RecursiveMenu, RecursiveMenuCollasped },

  mounted() {
    // dropdown profile js
    let Accordion = function (el, multiple) {
      this.el = el || {};
      this.multiple = multiple || false;

      // Variables privadas
      let links = this.el.find(".link");
      // Evento
      links.on(
        "click",
        {
          el: this.el,
          multiple: this.multiple,
        },
        this.dropdown
      );
    };

    Accordion.prototype.dropdown = function (e) {
      let el = e.data.el;
      (window.$this = window.$(this)), (window.$next = window.$this.next());

      window.$next.slideToggle();
      window.$this.parent().toggleClass("open");

      if (!e.data.multiple) {
        el.find(".submenu")
          .not(window.$next)
          .slideUp()
          .parent()
          .removeClass("open");
      }
    };

    new Accordion(window.$("#accordion"), false);
  },
  updated() {
    // dropdown profile js
    let Accordion = function (el, multiple) {
      this.el = el || {};
      this.multiple = multiple || false;

      // Variables privadas
      let links = this.el.find(".link");
      // Evento
      links.on(
        "click",
        {
          el: this.el,
          multiple: this.multiple,
        },
        this.dropdown
      );
    };

    Accordion.prototype.dropdown = function (e) {
      let el = e.data.el;
      (window.$this = window.$(this)), (window.$next = window.$this.next());

      window.$next.slideToggle();
      window.$this.parent().toggleClass("open");

      if (!e.data.multiple) {
        el.find(".submenu")
          .not(window.$next)
          .slideUp()
          .parent()
          .removeClass("open");
      }
    };

    new Accordion(window.$("#accordion"), false);
  },
};
</script>
