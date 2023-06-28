<template>
  <index-page></index-page>
</template>

<script>
// define model name
const model = "siteSetting";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "title", title: "Title" },
  { field: "short_title", title: "Short Title" },
  {
    field: "logo",
    title: "Logo",
    image: true,
    imgWidth: "80px",
  },
  { field: "contact_email", title: "Contact Email" },
];
//json fields for export excel
const json_fields = {
  "Role Name": "name",
  "Created at": "created_at",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: { 0: "Select One", title: "Title" },
      search_data: {
        pagination: 10,
        field_name: "title",
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
    this.setBreadcrumbs(this.model, "index", "Site Setting");
    this.search();
  },
};
</script>
