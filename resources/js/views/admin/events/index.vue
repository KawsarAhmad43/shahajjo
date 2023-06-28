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

      <div class="col-3">
        <div class="form-element">
          <input
            placeholder="Start date"
            v-model="search_data.from_date"
            class="form-control form-control-sm shadow-none"
            type="text"
            onfocus="(this.type='date')"
            id="date1"
          />
        </div>
      </div>
      <div class="col-3">
        <div class="form-element">
          <input
            placeholder="End Date"
            v-model="search_data.to_date"
            class="form-control form-control-sm shadow-none"
            type="text"
            onfocus="(this.type='date')"
            id="date2"
          />
        </div>
      </div>
      <!------------ Single Input ------------>
      <v-select-container title="" field="search_data.category_id" col="3">
        <v-select
          v-model="search_data.category_id"
          label="title"
          :reduce="(obj) => obj.id"
          :options="extraData.categories"
          placeholder="--Select Category--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "events";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "title", title: "Title" },
  { field: "category", title: "Category", subfield: "category.title" },
  {
    field: "thumb",
    title: "Image",
    image: true,
    imgWidth: "50px",
    align: "center",
  },
  { field: "venue", title: "Venue" },
  { field: "start_date", title: "Start_date" },
  { field: "end_date", title: "End_date" },
  {
    field: "sorting",
    title: "Sorting",
    sorting: true,
    namespace: "Events",
    auto: "",
    align: "center",
  },
  { field: "status", title: "Status", align: "center" },
];

//json fields for export excel
const json_fields = {
  Title: "title",
  Image: "image",
  Venue: "venue",
  "Start date": "start_date",
  "End date": "end_date",
  Sorting: "sorting",
  Status: "status",
  Description: "description",
};

export default {
  data() {
    return {
      extraData: {
        categories: [],
      },
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

  // provide inject for child component
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
    this.get_paginate(
      "category",
      { allData: true, module_name: "events" },
      "categories"
    );
  },
  validators: {
    "search_data.category_id": function (value = null) {
      return Validator.value(value);
    },
  },
};
</script>
