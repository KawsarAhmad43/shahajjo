<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <File
        title="Profile"
        field="data.profile"
        mime="img"
        fileClassName="file2"
      />
      <!------------ Single Input ------------>
      <Input v-model="data.name" field="data.name" title="Name" :req="true" />
      <!------------ Single Input ------------>
      <Input
        v-if="!$route.params.id"
        v-model="data.email"
        field="data.email"
        title="Email"
        :req="true"
      />
      <!------------ Single Input ------------>
      <Input
        v-model="data.password"
        field="data.password"
        title="Password"
        type="password"
        :req="true"
      />
      <!------------ Single Input ------------>
      <v-select-container title="Role" field="data.role_id" :req="true">
        <v-select
          v-model="data.role_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="extraData.roles"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>

      <!------------ Single Input ------------>
      <Input
        v-model="data.mobile"
        field="data.mobile"
        title="Mobile"
        :req="true"
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
const model = "admin";

export default {
  data() {
    return {
      model: model,
      data: {
        profile: "",
        role_id: null,
        status: "active",
        role_id: 1,
      },
      profile: {},
      extraData: {
        roles: [],
      },
    };
  },
  provide() {
    return {
      validate: this.validation,
      data: () => this.data,
      image: this.profile,
    };
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
        }

        var form = document.getElementById("form");
        var formData = new FormData(form);
        formData.append("role_id", this.data.role_id);

        // If there is no error
        if (res) {
          if (this.data.id) {
            this.update(this.model, formData, this.data.id, true);
          } else {
            this.store(this.model, formData);
          }
        }
      });
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create");
    }
    this.get_paginate("role", { allData: true }, "roles");
  },

  // validation rule for form
  validators: {
    "data.name": function (value = null) {
      return Validator.value(value).required("Name is required");
    },
    "data.email": function (value = null) {
      if (!this.$route.params.id) {
        return Validator.value(value).required("Email is required").email();
      }
    },
    "data.role_id": function (value = null) {
      return Validator.value(value).required("Role is required");
    },
    "data.password": function (value = null) {
      if (!this.$route.params.id) {
        return Validator.value(value)
          .required("Password is required")
          .minLength(6);
      }
    },
    "data.mobile": function (value = null) {
      return Validator.value(value)
        .digit()
        .regex("01+[0-9+-]*$", "Must start with 01.")
        .minLength(11)
        .maxLength(11);
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>
