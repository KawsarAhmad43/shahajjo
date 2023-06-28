<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
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
        v-if="!$route.params.id"
        v-model="data.password"
        field="data.password"
        title="Password"
        type="password"
        :req="true"
      />
      <!------------ Single Input ------------>
      <v-select-container title="Role">
        <v-select
          v-model="data.role_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="extraData.roles"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
        <span
          v-if="validation.hasError('data.role_id')"
          class="input-message danger"
        >
          {{ validation.firstError("data.role_id") }}
        </span>
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
          { value: 'activea', title: 'Active1' },
          { value: 'deactivea', title: 'Deactive2' },
        ]"
        :req="true"
        col="3"
      />
      <!------------ Single Input ------------>
      <Checkbox
        v-model="data.checkbox"
        field="data.checkbox"
        title="Checkbox"
        :list="[
          { value: 'active', title: 'Active' },
          { value: 'deactive', title: 'Deactive' },
          { value: 'activea', title: 'Active1' },
          { value: 'deactivea', title: 'Deactive2' },
        ]"
        :req="true"
        col="3"
      />

      <date-picker
        id="from-date"
        v-model="data.from_date"
        title="From Date"
        placeholder="From Date"
        col="2"
      >
      </date-picker>

      <!------------ Single Input ------------>
      <div class="col-12 mb-3">
        <label class="form-label">Description</label>
        <div class="col-12">
          <editor v-model="data.description" />
        </div>
      </div>
    </div>

    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
import Select from "../../../components/elements/Form/SelectContainer.vue";
import Editor from "../../../components/Form/CKEditor";

// define model name
const model = "admin";

export default {
  components: { Select, Editor },
  data() {
    return {
      model: model,
      data: {
        role_id: null,
        from_date: null,
        checkbox: [],
        status: "active",
      },
      extraData: {
        roles: [],
      },
    };
  },
  provide() {
    return {
      validate: this.validation,
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
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create");
    }
    // this.get_paginate("role", { allData: true }, "roles"); // get roles
  },
  // ================== validation rule for form ==================
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
  },
};
</script>
