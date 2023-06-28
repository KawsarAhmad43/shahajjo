<template>
  <index-page>
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
const model = "notice";

const tableColumns = [
  { field: "title", title: "Title" },
  { field: "notice_date", title: "Notice_date" },
  { field: "notice_end", title: "Notice end" },
  {
    field: "file",
    title: "File",
    pdf: true,
    imgWidth: "20px",

    align: "center",
  },
  { field: "status", title: "Status", align: "center" },
];

const json_fields = {
  Title: "title",
  "Notice date": "notice_date",
  Description: "description",
  File: "file",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: { 0: "Select One", title: "Title", venue: "Venue" },
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
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index");
    this.search();
  },
};
</script>
