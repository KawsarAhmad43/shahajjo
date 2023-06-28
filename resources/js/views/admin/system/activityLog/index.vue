<template>
  <index-page>
    <!-- search field -->
    <template v-slot:search-field>
      <div class="col-lg-2">
        <date-picker-only
          id="from-date"
          v-model="search_data.from_date"
          title="From Date"
          placeholder="From Date"
          col="2"
        >
        </date-picker-only>
      </div>
      <div class="col-lg-2">
        <date-picker-only
          id="from-date1"
          v-model="search_data.to_date"
          title="To Date"
          placeholder="From Date"
          col="2"
        >
        </date-picker-only>
      </div>
      <div class="col-lg-1">
        <select
          @change="search()"
          v-model="search_data.description"
          class="form-control form-control-sm"
        >
          <option value>All User</option>
          <option
            v-for="(admins, index) in extraData.admins"
            :key="index"
            v-bind:value="admins.name"
          >
            {{ admins.name }}
          </option>
        </select>
      </div>
      <div class="col-lg-1">
        <select
          @change="search()"
          v-model="search_data.action"
          class="form-control form-control-sm"
        >
          <option value>All</option>
          <option>Created</option>
          <option>Updated</option>
          <option>Deleted</option>
        </select>
      </div>
      <div class="col-lg-1">
        <select
          @change="search()"
          v-model="search_data.status"
          class="form-control form-control-sm"
        >
          <option value>All</option>
          <option value="r">Read</option>
          <option value="ur">Unread</option>
        </select>
      </div>
    </template>

    <template v-slot:button>
      <div class="col-lg-2 text-end">
        <button
          type="button"
          @click="allRead()"
          class="btn btn-sm btn-info text-white"
        >
          <i class="fa fa-newspaper-o"></i> Mark all as read
        </button>
      </div>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "activityLog";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "log_name", title: "Module" },
  { field: "description", title: "Description" },
  { field: "status", title: "Status", align: "center" },
  { field: "created_at", title: "Created at", date: true },
];
//json fields for export excel
const json_fields = {
  Module: "log_name",
  Description: "description",
  Status: "status",
  "Created at": "created_at",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: {
        0: "Select One",
        log_name: "Module",
        description: "Description",
      },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
        description: "",
        action: "",
        status: "ur",
        date: "",
      },
      extraData: {
        admins: [],
      },
      table: {
        columns: tableColumns,
        routes: {
          view: model + ".show",
          destroy: model + ".destroy",
        },
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
    destroy(id) {
      this.destroy_data(this.model, id, this.search_data);
    },
    search() {
      this.get_paginate(this.model, this.search_data);
    },
    allRead() {
      this.$root.spinner = true;
      axios
        .get("/allRead")
        .then((res) => {
          this.search();
          this.$toast(res.data.message, "success");
        })
        .catch((error) => console.log())
        .then((alw) => setTimeout(() => (this.$root.spinner = false), 200));
    },
  },
  created() {
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index", "Activity Log");
    this.search();
    this.get_paginate("admin", { allData: true }, "admins");
  },
};
</script>