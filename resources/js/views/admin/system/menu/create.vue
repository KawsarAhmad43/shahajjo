<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <v-select-container field="data.parent_id" title="Parent Menu">
        <v-select
          v-model="data.parent_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="allMenus"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>

      <!------------ Single Input ------------>
      <Input
        title="Menu Name"
        v-model="data.menu_name"
        field="data.menu_name"
        :req="true"
      />
      <!------------ Single Input ------------>
      <v-select-container field="data.icon" title="Menu Icon" :req="true">
        <v-select
          v-model="data.icon"
          label="icon"
          :reduce="(obj) => obj.icon"
          :options="icons"
          placeholder="--Select Any--"
          :closeOnSelect="true"
          :class="validation.hasError('data.icon') ? 'v-border' : ''"
        >
          <template #option="{ icon, icon_name }">
            <em v-html="icon"></em> &nbsp; {{ icon_name }}
          </template>
        </v-select>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        v-model="data.sorting"
        field="data.sorting"
        :req="true"
        col="2"
      />
      <!------------ Single Input ------------>
      <v-select-container field="data.route_name" title="Route Name">
        <v-select
          v-model="data.route_name"
          label="name"
          :reduce="(obj) => obj.id"
          :options="permissions"
          placeholder="--Select Any--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input title="Params" v-model="data.params" field="data.params" />
      <!------------ Single Input ------------>
      <Radio
        title="Show Dashboard"
        v-model="data.show_dasboard"
        field="data.show_dasboard"
        :list="[
          { value: 1, title: 'Yes' },
          { value: 0, title: 'No' },
        ]"
        :req="true"
        col="2"
      />
    </div>

    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
import icons from "./json/icon.json";

// define model name
const model = "menu";

export default {
  data() {
    return {
      model: model,
      allMenus: [],
      icons: icons,
      data: {
        sorting: 0,
        show_dasboard: 0,
      },
    };
  },
  provide() {
    return {
      validate: this.validation,
    };
  },
  computed: {
    permissions() {
      let arr = [];
      if (
        this.$root.permissions &&
        Object.keys(this.$root.permissions).length > 0
      ) {
        this.$root.permissions.forEach((routeName) => {
          arr.push({ id: routeName, name: routeName });
        });
      }
      return arr;
    },
  },
  methods: {
    submit: function (e) {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        // If there is an error

        if (error > 0) {
          console.log(this.validation.allErrors());
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
    getMenus() {
      axios.get("/get-menus/menu").then((res) => (this.allMenus = res.data));
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("System-Menu");
    }
    this.getMenus();
  },

  // validation rule for form
  validators: {
    "data.menu_name": function (value = null) {
      return Validator.value(value).required("Menu name is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).digit().required("Sorting is required");
    },
    "data.icon": function (value = null) {
      return Validator.value(value).required("Icon is required");
    },
  },
};
</script>
 