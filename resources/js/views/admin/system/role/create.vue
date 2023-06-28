<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Input v-model="data.name" field="data.name" title="Name" :req="true" />
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

      <div class="w-100 my-2"></div>
      <fieldset class="border border-primary w-100 p-2 rounded">
        <legend class="w-25 pl-1 font-weight-bold" style="font-size: 1.2rem">
          <p class="p-0 m-0">
            Permission Setting
            <span class="float-right pl-2">
              <input type="checkbox" value="1" v-model="checkAll" />
              <small>All</small>
            </span>
          </p>
        </legend>

        <table
          v-if="extraData.permissions"
          border="1"
          class="table border table-hover"
        >
          <tr v-for="(perm, index) in extraData.permissions" :key="index">
            <td class="controller" style="vertical-align: middle">
              <b>{{ perm.name.replace("Controller", "") }}</b>
            </td>
            <td class="action-wraper">
              <div class="row">
                <div
                  v-for="(process, index2) in perm.children"
                  :key="index2"
                  class="col-3 actions"
                >
                  <label class="text-capitalize">
                    <input
                      type="checkbox"
                      :value="process.id"
                      v-model="data.permissions"
                    />
                    {{ $filter.capitalize(process.name) }}
                  </label>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </fieldset>

      <!-------------- button -------------->
      <div class="col-12 mb-3 mt-2">
        <Button title="Submit" process="" />
      </div>
    </div>
  </create-form>
</template>

<script>
// define model name
const model = "role";

export default {
  data() {
    return {
      model: model,
      checkAll: null,
      data: { status: "active", permissions: [] },
      extraData: {
        permissions: [],
      },
      errors: {},
    };
  },
  provide() {
    return {
      validate: this.validation,
    };
  },
  watch: {
    checkAll: function (val, oldval) {
      this.data.permissions = [];
      if (val) {
        this.extraData.permissions.forEach((permission) => {
          permission.children.forEach((process) => {
            this.data.permissions.push(process.id);
          });
        });
      }
    },
  },
  methods: {
    submit: function () {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        // If there is an error
        if (error > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
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
    this.get_paginate("get-permissions", { allData: true }, "permissions");
  },

  // ================== validation rule for form ==================
  validators: {
    "data.name": function (value = null) {
      return Validator.value(value).required("Name is required");
    },
  },
};
</script>