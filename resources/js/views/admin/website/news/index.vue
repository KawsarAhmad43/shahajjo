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
      <div class="col-2">
        <div class="form-element">
          <input
            placeholder="From date"
            v-model="search_data.from_date"
            class="form-control form-control-sm shadow-none"
            type="text"
            onfocus="(this.type='date')"
            id="date1"
          />
        </div>
      </div>
      <div class="col-2">
        <div class="form-element">
          <input
            placeholder="To Date"
            v-model="search_data.to_date"
            class="form-control form-control-sm shadow-none"
            type="text"
            onfocus="(this.type='date')"
            id="date2"
          />
        </div>
      </div>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "news";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "date", title: "Date", date: true },
  { field: "title", title: "Title" },
  {
    field: "image",
    title: "Image",
    image: true,
    imgWidth: "30px",
    align: "center",
  },
  { field: "status", title: "Status", align: "center" },
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
      fields_name: {
        0: "Select One",
        title: "Title",
      },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
        status: "",
        from_date: "",
        to_date: "",
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
  },
};
</script>
