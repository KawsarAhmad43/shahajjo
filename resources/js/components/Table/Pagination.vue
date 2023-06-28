<template>
  <div
    v-if="table.meta && Object.keys(table.meta).length > 0"
    class="global-form-footer"
  >
    <div class="row">
      <div class="col-lg-6 align-self-center">
        <div class="number-of-show">
          <p>
            Showing {{ table.meta.from }} to {{ table.meta.to }} of
            {{ table.meta.total }} entries
          </p>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="pagination d-flex justify-content-end">
          <ul>
            <!-- First Page -->
            <li
              v-if="table.meta.last_page > 1"
              class="arrow"
              :class="table.meta.current_page == 1 ? 'disabled' : ''"
            >
              <a href="javascript:void(0)" @click="get_datas(1)">
                <i class="fa-solid fa-arrow-left"></i>
              </a>
            </li>

            <!-- Left Numbers -->
            <li class="mid-pagi">
              <template v-for="leftNum in decrement()" :key="leftNum">
                <a
                  v-if="leftNum > 0"
                  href="javascript:void(0)"
                  @click="get_datas(leftNum)"
                >
                  <span>{{ leftNum }}</span>
                </a>
              </template>

              <!-- Current Page -->
              <a class="active" @click="get_datas(table.meta.current_page)">
                <span> {{ table.meta.current_page }}</span>
              </a>

              <!-- Right Numbers -->
              <template v-for="rightNum in 6" :key="rightNum">
                <a
                  v-if="
                    table.meta.current_page + rightNum <= table.meta.last_page
                  "
                  href="javascript:void(0)"
                  @click="get_datas(table.meta.current_page + rightNum)"
                >
                  <span>{{ table.meta.current_page + rightNum }}</span>
                </a>
              </template>
            </li>

            <!-- Last Page -->
            <li
              v-if="table.meta.current_page < table.meta.last_page"
              class="arrow"
            >
              <a
                href="javascript:void(0)"
                @click="get_datas(table.meta.last_page)"
              >
                <i class="fa-solid fa-arrow-right"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Pagination",

  inject: ["table", "search_data", "model", "customDataUrl", "customRouteName"],

  methods: {
    get_datas: function (page_index) {
      let page = page_index ? page_index : this.$route.query.page;
      let customRouteName = this.customRouteName
        ? this.customRouteName
        : this.model + ".index";
      this.$router.push({ name: customRouteName, query: { page: page } });

      let dataUrl = this.customDataUrl ? this.customDataUrl : this.model;
      let url = dataUrl + "?page=" + page;

      this.$root.tableSpinner = true;
      axios
        .get(`${laravel.baseurl}/${url}`, { params: this.search_data })
        .then((res) => {
          this.table.datas = res.data.data;
          this.table.meta = res.data.meta;
          this.table.links = res.data.links;
          setTimeout(() => (this.$root.tableSpinner = false), 200);
        })
        .catch((error) =>
          setTimeout(() => (this.$root.tableSpinner = false), 200)
        );
    },

    // Decrement Page Loop
    decrement() {
      let curentPage = this.table.meta.current_page - 1;
      let arr = [];
      for (var i = 1; i <= 6; i++) {
        if (curentPage > 0) {
          arr.unshift(curentPage--);
        }
      }
      return arr;
    },
  },
};
</script>