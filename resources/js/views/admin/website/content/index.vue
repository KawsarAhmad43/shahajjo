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
          <option value="deactive">Deactive</option>
        </select>
      </div>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "content";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "title", title: "Title", to: "content.show", slug: "slug" },
  { field: "status", title: "Status", align: "center" },
];

//json fields for export excel
const json_fields = {
  Title: "title",
  "Created at": "created_at",
};

// routes name
const routes = {
  destroy: "content.destroy",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: { 0: "Select One", title: "Title" },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
        status: "",
      },
      table: {
        columns: tableColumns,
        routes: routes,
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
      customDataUrl: this.model,
      customRouteName: "content.index",
      json_fields: this.json_fields,
      search: this.search,
    };
  },

  methods: {
    search() {
      this.get_paginate(this.model, this.search_data);
    },
  },

  created() {
    this.scrollTop();
    this.setBreadcrumbs(this.model, "index", "Content");
    this.search();
  },
};
</script>
