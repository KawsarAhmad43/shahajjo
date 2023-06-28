<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <v-select-container field="" title="Parent Menu">
        <v-select
          v-model="data.parent_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="parentMenu"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input
        v-model="data.title"
        field="data.title"
        title="Title"
        :req="true"
      />
      <v-select-container field="" title="Menu Type">
        <v-select
          v-model="data.type"
          label="name"
          :reduce="(obj) => obj.id"
          :options="menu_types"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>

      <!------------ Single Input ------------>
      <v-select-container field="" title="Menu Look Type">
        <v-select
          v-model="data.menu_look_type"
          label="name"
          :reduce="(obj) => obj.id"
          :options="menu_look_types"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
      <!------------ Single Input ------------>
      <v-select-container title="Content" v-if="data.type == 'content'">
        <v-select
          v-model="data.content_id"
          label="title"
          :reduce="(obj) => obj.id"
          :options="extraData.contents.data"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input
        v-if="data.type == 'outside_website' || data.type == 'external_link'"
        :title="data.type == 'outside_website' ? 'URL' : 'Route Name'"
        field="data.url"
        v-model="data.url"
        :req="true"
        col="2"
      />
      <!------------ Single Input ------------>
      <Input
        title="Params"
        field="data.params"
        v-model="data.params"
        :req="true"
        col="2"
      />
      <!------------ Single Input ------------>
      <v-select-container field="" title="Menu Position">
        <v-select
          v-model="data.position"
          label="name"
          :reduce="(obj) => obj.id"
          :options="positions"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        :req="true"
        col="2"
      />
      <!------------ Single Input ------------>
      <Radio
        v-model="data.status"
        field="data.status"
        title="Status"
        :list="[
          { value: 'active', title: 'Active' },
          { value: 'deactive', title: 'Deactive' },
        ]"
        :req="true"
        col="2"
      />
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "frontMenu";

export default {
  data() {
    return {
      selectedValue: null,
      model: model,
      extraData: {
        contents: [],
      },
      positions: [
        { id: "header", name: "Header" },
        { id: "top_bar", name: "Top Bar" },
        { id: "footer_bottom", name: "Footer Bottom" },
        { id: "footer_information", name: "Footer Information" },
      ],
      menu_look_types: [
        { id: "normal", name: "Normal" },
        { id: "mega", name: "Mega" },
      ],
      menu_types: [
        { id: "content", name: "Content" },
        { id: "external_link", name: "External Link" },
        { id: "outside_website", name: "Outside Website" },
      ],
      parentMenu: [],
      data: {
        parent_id: "",
        content_id: "",
        menu_type: "",
        position: "header",
        content: "",
        menu_look_type: "normal",
        status: "active",
        sorting: 0,
      },
    };
  },
  provide() {
    return {
      validate: this.validation,
    };
  },
  methods: {
    submit: function () {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        // If there is an error
        if (error > 0) {
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
          return false;
        }

        // If there is no error
        if (res) {
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id);
          } else {
            this.store(this.model, this.data);
          }
        }
      });
    },
    get_parent: function () {
      axios.get("/parent-menus").then((res) => (this.parentMenu = res.data));
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit", "Menu");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create", "Menu");
      this.get_sorting("Website-FrontMenu");
    }

    this.get_parent();
    this.get_paginate("get-content", { allData: true }, "contents");
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },

    "data.position": function (value = null) {
      return Validator.value(value).required("Menu Position is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>