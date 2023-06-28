<template >
  <index-page :defaultTable="false" :searchBlock="false">
    <template v-slot:search-field>
      <div class="col-lg-2">
        <select
          v-model="search_data.status"
          @change="search()"
          class="form-select shadow-none"
        >
          <option value="">Status</option>
          <option value="">All</option>
          <option value="active">Active</option>
          <option value="draft">Draft</option>
        </select>
      </div>
      <div class="col-lg-2">
        <select
          v-model="search_data.type"
          @change="search()"
          class="form-select shadow-none"
        >
          <option value="">Type</option>
          <option value="">All</option>
          <option value="Photos">Photos</option>
          <option value="Videos">Videos</option>
        </select>
      </div>
      <div class="row col-5 pl-1">
        <div class="col-lg-5">
          <div class="form-element">
            <select
              v-model="search_data.field_name"
              class="form-select shadow-none"
            >
              <option
                v-for="(value, name, index) in fields_name"
                :key="index"
                v-bind:value="name"
              >
                {{ value }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-element">
            <input
              type="text"
              v-model="search_data.value"
              class="form-control form-control-sm shadow-none"
              placeholder="Type your text"
            />
          </div>
        </div>
        <div class="col-lg-1">
          <button type="submit" class="search-btn">
            <div class="btn-front">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="btn-back">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
          </button>
        </div>
      </div>
    </template>

    <template v-slot:table-list>
      <div class="gallery-list">
        <div class="row">
          <div
            v-for="(item, index) in this.table.datas"
            :key="index"
            class="col-sm-6 col-lg-4 col-xl-3"
          >
            <div class="image">
              <img :src="item.image" :alt="item.name" />
              <div class="overlay">
                <div class="info">
                  <router-link
                    v-if="
                      table.routes.view &&
                      $root.checkPermission(table.routes.view)
                    "
                    :to="{
                      name: table.routes.view,
                      params: { id: item.id },
                      query: { page: $route.query.page },
                    }"
                    class="delete view"
                    title="View"
                  >
                    <i class="fa-solid fa-eye"></i>
                  </router-link>

                  <router-link
                    v-if="
                      table.routes.edit &&
                      $root.checkPermission(table.routes.edit)
                    "
                    :to="{
                      name: table.routes.edit,
                      params: { id: item.id },
                      query: { page: $route.query.page },
                    }"
                    class="delete edit"
                    title="Edit"
                  >
                    <i class="fas fa-pencil-alt"> </i>
                  </router-link>

                  <button
                    v-if="
                      table.routes.destroy &&
                      $root.checkPermission(table.routes.destroy)
                    "
                    v-on:click="destroy(item.id)"
                    class="delete delete-btn"
                    title="Delete"
                  >
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <!-- <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" class="delete view"><i
                        class="fa-solid fa-eye"></i></span>
                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" class="delete edit"><i
                        class="fas fa-pencil-alt"></i></span>
                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"
                      class="delete delete-btn"><i class="far fa-trash-alt"></i></span> -->
                  <div>
                    <router-link
                      v-if="
                        table.routes.view &&
                        $root.checkPermission(table.routes.view)
                      "
                      :to="{
                        name: 'photo.create',
                        query: { id: item.id },
                      }"
                      title="View"
                      ><button
                        class="manage-gallery btn btn-primary shadow-none mt-4"
                      >
                        Manage Gallery
                      </button>
                    </router-link>
                  </div>
                  <h4>{{ item.name }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal -->
      <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="deleteModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-black" id="deleteModalLabel">
                Are you sure want to delete this?
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <h6 class="mb-3 text-black">
                Please confirm your login password
              </h6>
              <div class="d-flex justify-content-center">
                <input
                  v-model="delete_password"
                  type="password"
                  placeholder="********"
                  class="form-control form-control-sm text-center border"
                  style="width: 350px"
                />
              </div>
              <div class="d-flex justify-content-center">
                <button
                  @click="deleteConfirm()"
                  type="button"
                  class="btn btn-success btn-sm text-white my-3"
                >
                  <span v-if="$root.submit">
                    <i class="fa fa-spinner fa-spin"></i>
                    processing...
                  </span>
                  <span v-else> Confirm </span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "album";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "name", title: "Name", to: "photo.create" },
  { field: "type", title: "Type", align: "center" },
  {
    field: "image",
    title: "Image",
    image: true,
    imgWidth: "50px",
    height: "50px",
    align: "center",
  },
  {
    field: "sorting",
    title: "Sorting",
    sorting: true,
    namespace: "Website-FrontMenu",
    auto: "",
    align: "center",
  },
];
//json fields for export excel
const json_fields = {
  Title: "title",
  "Created at": "created_at",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: { 0: "Select One", name: "Name" },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
        status: "",
        type: "",
      },
      table: {
        columns: tableColumns,
        routes: {},
        datas: [],
        meta: [],
        links: [],
      },
    };
  },

  // provide inject for child component
  provide() {
    return {
      model: this.model,
      fields_name: this.fields_name,
      search_data: this.search_data,
      table: this.table,
    };
  },

  methods: {
    search() {
      console.log(this.search_data);
      this.get_paginate(this.model, this.search_data);
      // axios.get(this.model, this.search_data).then(e => {
      //   this.albums = e.data.data
      // });
    },

    destroy(id) {
      this.deleted_id = id;
      $("#deleteModal").modal("show");
    },
    deleteConfirm() {
      if (!this.delete_password) {
        this.$toast("Password field is required", "error");
        return false;
      }
      let data = {
        for_delete: true,
        id: this.user.id,
        old_password: this.delete_password,
      };
      this.$root.submit = true;
      axios
        .post("/check-old-password", data)
        .then((res) => {
          if (res.data) {
            this.destroy_data(this.model, this.deleted_id, this.search_data);
            this.deleted_id = "";
            this.delete_password = "";

            $("#deleteModal").modal("hide");
          } else {
            this.$toast("Password does not match", "error");
            return false;
          }
        })
        .finally((res) => (this.$root.submit = false));
    },
  },

  created() {
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index");
    this.search();
  },
};
</script>
