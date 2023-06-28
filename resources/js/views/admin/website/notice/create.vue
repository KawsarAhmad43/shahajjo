<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <v-select-container req field="data.type" title="Notice Type" col="2">
        <v-select
          v-model="data.type"
          label="name"
          :reduce="(obj) => obj.value"
          :options="types"
          placeholder="--Select One--"
          :closeOnSelect="true"
          :req="true"
        ></v-select>
      </v-select-container>

      <File
        title="File"
        field="data.file"
        mime=".pdf"
        fileClassName="data.file"
        v-if="data.type == 'file'"
        :req="true"
        col="3"
      />

      <Input
        v-model="data.title"
        field="data.title"
        title="Title"
        :req="true"
        col="6"
      />
      <date-picker
        id="date1"
        field="data.notice_date"
        name="notice_date"
        v-model="data.notice_date"
        title="Notice_date"
        placeholder="Notice_date"
        :req="true"
        col="3"
      ></date-picker>

      <date-picker
        id="date2"
        field="data.notice_end"
        name="notice_end"
        v-model="data.notice_end"
        title="Notice_end"
        placeholder="Notice_end"
        col="3"
      ></date-picker>

      <div class="col-12 mb-3" v-if="data.type == 'content'">
        <label class="form-label"
          >Description <sup class="text-danger">*</sup></label
        >
        <div
          class="col-12"
          :class="{
            'border-red': validation.hasError('data.description'),
            'border-green': data.description,
          }"
        >
          <editor v-model="data.description" />
        </div>
        <span class="text-danger">{{
          validation.firstError("data.description")
        }}</span>
      </div>
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
import Editor from "../../../../components/Form/CKEditor.vue";

// define model name
const model = "notice";

export default {
  components: { Editor },

  data() {
    return {
      model: model,
      data: { file: "", status: "active" },
      image: {},
      types: [
        { name: "File", value: "file" },
        { name: "Content", value: "content" },
      ],
    };
  },

  provide() {
    return {
      validate: this.validation,
      data: () => this.data,
      image: this.image,
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
          var form = document.getElementById("form");
          var formData = new FormData(form);
          formData.append(
            "description",
            this.data.description ? this.data.description : ""
          );
          formData.append("type", this.data.type);
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
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.notice_date": function (value = null) {
      return Validator.value(value).required("Notice date is required");
    },
    "data.type": function (value = null) {
      return Validator.value(value).required("Type is required");
    },
    "data.file": function (value = null) {
      if (this.data.type == "file") {
        return Validator.value(value).required("File is required");
      } else {
        this.validation.errors.forEach((e, i) => {
          if (e.field == "data.file") {
            this.validation.errors.splice(i, 1);
          }
        });
      }
    },
    "data.description": function (value = null) {
      if (this.data.type == "content") {
        return Validator.value(value).required("Description is required");
      } else {
        this.validation.errors.forEach((e, i) => {
          if (e.field == "data.description") {
            this.validation.errors.splice(i, 1);
          }
        });
      }
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>

<style scoped>
.border-red {
  border: 1px solid rgb(255 0 0);
}
.border-green {
  border: 1px solid rgb(25 135 84) !important;
}
</style>
