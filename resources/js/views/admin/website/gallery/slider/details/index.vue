<template>
  <index-page>
    <template v-slot:extraRoute>
      <button>+</button>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "slider";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "title", title: "Title" },
  { field: "position", title: "Position" },
  { field: "image_width", title: " Image Width " },
  { field: "image_height", title: " Image Height " },
  { field: "status", title: " Status  " },
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
      fields_name: {
        0: "Select One",
        title: "Title",
        position: "Position",
        image_height: "Image height",
        image_width: "Image width",
        status: "status",
      },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
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
    this.table.routes.array = [
      {
        route: "slider-details.create",
        icon: "tasks",
        btnColor: "text-danger",
      },
    ];
  },
};
</script>
