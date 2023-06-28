<template>
  <index-page>
    <!-- search field -->
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
      <!------------ Single Input ------------>
      <v-select-container title="" field="search_data.album_id" col="3">
        <v-select
          v-model="search_data.album_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="extraData.albums"
          placeholder="--Select Album--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "video";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "album", title: "Album Name", subfield: "album.name" },
  {
    field: "thumbnail",
    title: "Thumbnail",
    image: true,
    imgWidth: "50px",
    height: "50px",
    align: "center",
  },
  { field: "title", title: "Title" },
  { field: "url", title: "URL" },
  { field: "status", title: "Status", align: "center" },
  {
    field: "sorting",
    title: "Sorting",
    sorting: true,
    namespace: "Website-Gallery-Album",
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
      extraData: {
        albums: [],
      },
      model: model,
      json_fields: json_fields,
      fields_name: {
        0: "Select One",
        album_name: "Album Name",
        title: "Title",
        url: "Url",
      },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
        status: "",
        album_id: "",
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
      this.get_paginate(this.model, this.search_data);
    },
  },
  created() {
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index");
    this.search();
    this.get_paginate("album", { allData: true, type: "Videos" }, "albums");
  },
  validators: {
    "search_data.album_id": function (value = null) {
      return Validator.value(value);
    },
  },
};
</script>
