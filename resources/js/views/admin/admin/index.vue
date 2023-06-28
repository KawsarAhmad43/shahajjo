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
      <!------------ Single Input ------------>
      <v-select-container title="" field="search_data.role_id" col="3">
        <v-select
          v-model="search_data.role_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="extraData.roles"
          placeholder="--Select Role--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
    </template>
  </index-page>
</template>

<script>
// define model name
const model = "admin";

// define table coloumn show in datatable / datalist
const tableColumns = [
  {
    field: "profile",
    title: "Profile",
    image: true,
    imgWidth: "30px",
    align: "center",
  },
  { field: "name", title: "Name" },
  { field: "email", title: "Email" },
  { field: "role", title: "Role Name", subfield: "role.name" },
  { field: "mobile", title: "Mobile" },
  { field: "status", title: "Status", align: "center" },
  { field: "created_at", title: "Created at", align: "center", date: true },
];
//json fields for export excel
const json_fields = {
  "Role Name": "name",
  "Email ": "email",
  "Mobile ": "mobile",
};

export default {
  data() {
    return {
      extraData: {
        roles: [],
      },
      model: model,
      json_fields: json_fields,
      fields_name: {
        0: "Select One",
        name: "Name",
        email: "Email",
        mobile: "Mobile",
      },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
        status: "",
        role_id: "",
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
      validate: this.validation,
    };
  },

  methods: {
    search() {
      this.get_paginate(this.model, this.search_data);
    },
    systemRoleUpdate() {
      axios.get("/systems-update").then((res) => {
        this.notification(res.data.message, "success");
      });
    },
  },
  created() {
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index");
    this.search();
    this.get_paginate("role", { allData: true }, "roles");
  },
  validators: {
    "search_data.role_id": function (value = null) {
      return Validator.value(value);
    },
  },
};
</script>
