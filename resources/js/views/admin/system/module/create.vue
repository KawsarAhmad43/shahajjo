<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Input
        v-model="data.model_name"
        field="data.model_name"
        title="Model Name"
        :req="true"
      />
      <div class="col-lg-4 mt-3">
        <label class="form-label">Only Model : </label> &nbsp;
        <input type="checkbox" value="1" v-model="data.only_model" />
      </div>
      <div class="col-lg-5 mb-3">
        <!-- Button trigger modal -->
        <button
          type="button"
          class="btn btn-danger btn-sm ms-5 float-end"
          data-bs-toggle="modal"
          data-bs-target="#deleteModal"
        >
          Module Delete
        </button>

        <!-- Modal -->
        <div
          class="modal fade"
          id="deleteModal"
          tabindex="-1"
          aria-labelledby="deleteModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-dark" id="deleteModalLabel">
                  Delete Module
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <input
                  type="text"
                  style="width: 75%; float: left"
                  class="form-control form-control-sm"
                  name=""
                  @input="checkModuleExist"
                />

                <button
                  type="button"
                  @click.prevent="deleteModule"
                  v-if="deleteButton"
                  class="btn btn-danger btn-sm ms-2 text-white"
                >
                  Delete
                </button>
                <button
                  type="button"
                  v-else
                  class="btn btn-secondary btn-sm ms-2 text-dark"
                  disabled
                >
                  Delete
                </button>
                <span class="text-danger">{{ moduleNotExist }}</span>
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- DB Design -->
      <div class="col-lg-12 mt-4">
        <h4 class="text-black">DB Design</h4>

        <table class="table table-bordered">
          <thead>
            <tr>
              <td style="width: 15%">Field Name</td>
              <td style="width: 13%">Input type</td>
              <td style="width: 13%">Type</td>
              <td style="width: 13%">Length</td>
              <td style="width: 7%">Unsigned</td>
              <td style="width: 8%">Validation</td>
              <td style="width: 10%">Index Page</td>
              <td style="width: 5%">Action</td>
            </tr>
          </thead>

          <tbody v-if="data.databases" class="border-1">
            <tr v-for="(db, key) in data.databases" :key="key">
              <td>
                <input
                  v-model="db.field_name"
                  type="text"
                  placeholder="Enter field name"
                  class="form-control"
                />
                <small class="text-danger">
                  {{ errors[`${key}.field_name`] }}
                </small>
              </td>
              <td>
                <select v-model="db.input_type" class="form-select">
                  <option value="">--Select One--</option>
                  <option value="text">Text</option>
                  <option value="select">Select</option>
                  <option value="textarea">Textarea</option>
                  <option value="radio">Radio</option>
                  <option value="checkbox">Checkbox</option>
                  <option value="date">Datepicker</option>
                  <option value="image">Image</option>
                  <option value="file">File</option>
                </select>
                <small class="text-danger">
                  {{ errors[`${key}.input_type`] }}
                </small>
              </td>
              <td>
                <v-select-container
                  :col="12"
                  style="margin-bottom: 0px !important"
                >
                  <v-select
                    v-model="db.type"
                    label="value"
                    :reduce="(obj) => obj.id"
                    :options="types"
                    placeholder="--Select Any--"
                    :closeOnSelect="true"
                  >
                  </v-select>
                </v-select-container>
                <small class="text-danger capitalize">
                  {{ errors[`${key}.type`] }}
                </small>
              </td>
              <td>
                <input
                  v-model="db.length"
                  type="text"
                  placeholder="Length"
                  class="form-control"
                />
                <small class="text-danger">
                  {{ errors[`${key}.length`] }}
                </small>
              </td>
              <td style="display: none">
                <select v-model="db.unsigned" class="form-select">
                  <option :value="1">Yes</option>
                  <option :value="0">No</option>
                </select>
              </td>
              <td style="display: none">
                <select v-model="db.default" class="form-select">
                  <option :value="1">As Defined</option>
                  <option :value="0">None</option>
                </select>

                <input
                  v-if="db.default == 1"
                  v-model="db.default_value"
                  type="text"
                  class="form-control mt-2"
                  placeholder="Default Value"
                />
              </td>
              <td>
                <select v-model="db.index" class="form-select">
                  <option :value="0">No</option>
                  <option value="unique">Unique</option>
                  <option value="index">Index</option>
                  <option value="primary">Primary</option>
                </select>
              </td>

              <td>
                <!-- Button trigger modal -->
                <button
                  type="button"
                  class="btn btn-outline-dark"
                  data-bs-toggle="modal"
                  :data-bs-target="`#exampleModal${key}`"
                >
                  Validations
                </button>

                <!-- Modal -->
                <div
                  class="modal fade"
                  :id="`exampleModal${key}`"
                  tabindex="-1"
                  aria-labelledby="exampleModalLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                          Validations Rules
                        </h5>
                        <button
                          type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                        ></button>
                      </div>
                      <div class="modal-body">
                        <div
                          class="row"
                          v-for="(valiRules, ind) in db.validations"
                          :key="ind"
                        >
                          <div class="col-8 mb-2 form-group">
                            <select
                              name=""
                              class="form-control form-control-sm"
                              v-model="valiRules.validation_type"
                            >
                              <option value="">Select one</option>
                              <option value="required">Required</option>
                              <option value="email">Email</option>
                              <option value="number">Number</option>
                              <option value="url">URL</option>
                              <option value="image">Image</option>
                              <option value="file">File</option>
                              <option value="minLength">MinLength</option>
                              <option value="maxLength">MaxLength</option>
                              <option value="fileOrImageSize">
                                File/Image Size
                              </option>
                            </select>
                          </div>
                          <!-- for add and remove button -->
                          <div class="col-4">
                            <!-- minus button -->
                            <button
                              style="
                                padding: 1px 6px !important;
                                min-width: 10px;
                              "
                              type="button"
                              @click.prevent="db.validations.splice(ind, 1)"
                              v-if="Object.keys(db.validations).length > 1"
                              class="btn btn-danger"
                            >
                              <i class="fa fa-minus"></i>
                            </button>
                            <!-- plus button -->
                            <button
                              type="button"
                              v-if="
                                Object.keys(db.validations).length == ind + 1
                              "
                              style="
                                padding: 1px 6px !important;
                                min-width: 10px;
                              "
                              @click.prevent="
                                db.validations.push({
                                  validation_type: '',
                                  file_type: [],
                                  image_type: [],
                                })
                              "
                              class="btn btn-info ms-2"
                            >
                              <i class="fa fa-plus"></i>
                            </button>
                          </div>
                          <!-- Condition for image field  -->
                          <div
                            class="col-8 form-group mt-3 mb-3"
                            style="display: flex"
                            v-if="valiRules.validation_type == 'image'"
                          >
                            <div class="form-check me-3">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="jpg"
                                v-model="valiRules.image_type"
                                :id="`flexCheck${ind + 1 * 2}`"
                              />
                              <label
                                class="form-check-label text-dark"
                                :for="`flexCheck${ind + 1 * 2}`"
                              >
                                JPG
                              </label>
                            </div>
                            <div class="form-check me-3">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="jpeg"
                                v-model="valiRules.image_type"
                                :id="`flexCheck${ind + 1 * 7}`"
                              />
                              <label
                                class="form-check-label text-dark"
                                :for="`flexCheck${ind + 1 * 7}`"
                              >
                                JPEG
                              </label>
                            </div>

                            <div class="form-check me-3">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="webp"
                                v-model="valiRules.image_type"
                                :id="`flexCheck${ind + 1 * 5}`"
                              />
                              <label
                                class="form-check-label text-dark"
                                :for="`flexCheck${ind + 1 * 5}`"
                              >
                                WEBP
                              </label>
                            </div>
                            <div class="form-check me-3">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="png"
                                v-model="valiRules.image_type"
                                :id="`flexCheck${ind + 1 * 6}`"
                              />
                              <label
                                class="form-check-label text-dark"
                                :for="`flexCheck${ind + 1 * 6}`"
                              >
                                PNG
                              </label>
                            </div>
                          </div>
                          <!-- end Condition for image field -->

                          <!-- Additional field for file-->
                          <div
                            class="col-8 form-group mt-3 mb-3"
                            style="display: flex"
                            v-if="valiRules.validation_type == 'file'"
                          >
                            <div class="form-check me-3">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="word"
                                v-model="valiRules.file_type"
                                :id="`flexCheckDefault2${ind + 1 * 2}`"
                              />
                              <label
                                class="form-check-label text-dark"
                                :for="`flexCheckDefault2${ind + 1 * 2}`"
                              >
                                Word
                              </label>
                            </div>
                            <div class="form-check me-3">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="pdf"
                                v-model="valiRules.file_type"
                                :id="`flexCheckDefault3${ind + 1 * 3}`"
                              />
                              <label
                                class="form-check-label text-dark"
                                :for="`flexCheckDefault3${ind + 1 * 3}`"
                              >
                                PDF
                              </label>
                            </div>
                            <div class="form-check me-3">
                              <input
                                class="form-check-input"
                                type="checkbox"
                                value="excel"
                                v-model="valiRules.file_type"
                                :id="`flexCheckDefault5${ind + 1 * 5}`"
                              />
                              <label
                                class="form-check-label text-dark"
                                :for="`flexCheckDefault5${ind + 1 * 5}`"
                              >
                                Excel
                              </label>
                            </div>
                          </div>
                          <!-- end Additional field file -->

                          <!-- Minimum Length -->
                          <div
                            class="col-8 form-group mt-3 mb-3"
                            v-if="valiRules.validation_type == 'minLength'"
                          >
                            <input
                              type="text"
                              v-model="valiRules.minLength"
                              class="form-control form-control-sm"
                              placeholder="minlength"
                              name=""
                            />
                          </div>
                          <!-- end minimum length -->

                          <!-- maximum length -->
                          <div
                            class="col-8 form-group mt-3 mb-3"
                            v-if="valiRules.validation_type == 'maxLength'"
                          >
                            <input
                              type="text"
                              v-model="valiRules.maxLength"
                              class="form-control form-control-sm"
                              placeholder="maxlength"
                              name=""
                            />
                          </div>
                          <!-- end maximum length -->

                          <!--Start Image /File Size  -->
                          <div
                            class="col-8 mt-3 mb-3"
                            v-if="
                              valiRules.validation_type == 'fileOrImageSize'
                            "
                          >
                            <div class="input-group">
                              <input
                                type="text"
                                class="form-control form-control-sm"
                                v-model="valiRules.fileSize"
                                placeholder="file Or Image Size "
                                aria-label="Username"
                                aria-describedby="basic-addon1"
                              />
                              <span class="input-group-text" id="basic-addon1"
                                >KB</span
                              >
                            </div>
                          </div>
                          <!--end Image /File Size  -->

                          <!-- end additional field -->
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button
                          type="button"
                          data-bs-dismiss="modal"
                          class="btn btn-outline-info"
                        >
                          Save changes
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <input
                  type="checkbox"
                  class="mt-2"
                  :id="`showList${key}`"
                  v-model="db.showList"
                />
                <label :for="`showList${key}`" class="ms-2">Show List</label>
              </td>
              <td>
                <button
                  v-if="Object.keys(data.databases).length > 1"
                  @click="data.databases.splice(key, 1)"
                  type="button"
                  class="btn btn-sm btn-danger"
                  style="padding: 1px 6px !important; min-width: 10px"
                >
                  <i class="fa fa-minus"></i>
                </button>
                <button
                  v-if="Object.keys(data.databases).length == key + 1"
                  @click="
                    data.databases.push({
                      field_name: null,
                      type: 'string',
                      length: 225,
                      input_type: 'text',
                      default: 0,
                      unsigned: 0,
                      validations: [
                        {
                          validation_type: '',
                          file_type: [],
                          image_type: [],
                        },
                      ],
                      index: 0,
                    })
                  "
                  type="button"
                  class="btn btn-sm btn-primary ms-2"
                  style="padding: 1px 6px !important; min-width: 10px"
                >
                  <i class="fa fa-plus"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-------------- button -------------->
      <div class="col-12 mb-3 mt-2">
        <Button title="Submit" process="" />
      </div>
    </div>
  </create-form>
</template>

<script>
import Promise from "bluebird";

// define model name
const model = "module";

// set breadcrumb
const breadcrumb = [{ route: "module.create", title: "Module Create" }];

export default {
  data() {
    return {
      model: model,
      deleteModel: "",
      disabled: false,
      deleteButton: false,
      model_exist: false,
      types: [
        { id: "foreignId", value: "Foreign ID" },
        { id: "bigIncrements", value: "Big Increments" },
        { id: "integer", value: "Integer" },
        { id: "bigInteger", value: "Big Integer" },
        { id: "tinyInteger", value: "Tiny Integer" },
        { id: "string", value: "String" },
        { id: "binary", value: "Binary" },
        { id: "boolean", value: "Boolean" },
        { id: "char", value: "Char" },
        { id: "dateTime", value: "Date Time" },
        { id: "date", value: "Date" },
        { id: "decimal", value: "Decimal" },
        { id: "double", value: "Double" },
        { id: "enum", value: "Enum" },
        { id: "float", value: "Float" },
        { id: "json", value: "Json" },
        { id: "text", value: "Text" },
        { id: "longText", value: "Long Text" },
      ],
      data: {
        databases: [
          {
            field_name: null,
            type: "string",
            length: 225,
            input_type: "text",
            default: 0,
            unsigned: 0,
            validations: [
              {
                validation_type: "",
                file_type: [],
                image_type: [],
              },
            ],
            index: 0,
          },
        ],
        model_name: "",
      },
      validateFields: {
        field_name: null,
        type: null,
        length: null,
      },
      errors: {},
      debounce: null,
      moduleNotExist: "",
    };
  },
  watch: {
    "data.databases": {
      deep: true,
      handler() {
        this.databasesValidate();
      },
    },
  },
  provide() {
    return {
      validate: this.validation,
    };
  },
  methods: {
    submit: function () {
      this.$validate().then((res) => {
        this.databasesValidate();
        let errors = Object.keys(this.errors).length;
        const error = this.validation.countErrors();
        let countError = errors + error;
        if (countError > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            "You need to fill " + countError + " more empty mandatory fields",
            "warning"
          );
          return false;
        }

        if (res) {
          this.$root.submit = true;
          axios
            .post("/module/create", this.data)
            .then((res) => {
              this.$toast("Module Create Successfully", "success");
              this.$router.push({
                name: this.model + ".index",
                params: { model: this.data.model_name },
              });
            })
            .catch((error) =>
              this.$toast(
                "Something went wrong, but Some file are crated, please check",
                "error"
              )
            )
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },

    databasesValidate() {
      this.errors = {};
      // this.data.databases.forEach((obj, ind) => {
      //   for (const [field_name, value] of Object.entries(this.validateFields)) {
      //     if (obj.hasOwnProperty(field_name) && !obj[field_name]) {
      //       let text = field_name.split("_").join(" ");
      //       this.setErrors(text + " is required", ind, field_name);
      //     }
      //   }
      // });
      this.data.databases.forEach((db, index) => {
        if (!db.field_name) {
          this.setErrors(index, "field_name", "Field name is required");
        } else if (!db.input_type) {
          this.setErrors(index, "input_type", "Input type is required");
        } else if (!db.type) {
          this.setErrors(index, "type", "Type is required");
        } else if (
          db.type == "string" ||
          db.type == "integer" ||
          db.type == "char" ||
          db.type == "decimal" ||
          db.type == "float" ||
          db.type == "double"
        ) {
          if (!db.length) {
            this.setErrors(index, "length", "length is required");
          }
        }
      });
    },
    setErrors(index, prop, message) {
      this.errors = {
        ...this.errors,
        [`${index}.${prop}`]: message,
      };
    },
    deleteModule() {
      if (confirm("Are you sure? Do you want to delete?")) {
        axios
          .get("module-delete", { params: { model: this.deleteModel } })
          .then((res) => {
            this.deleteModel = "";
            this.$toast(res.data.message, "success");
          });
      }
    },
    checkModuleExist(event) {
      this.deleteModel = null;
      clearTimeout(this.debounce);
      this.debounce = setTimeout(() => {
        this.deleteModel = event.target.value;

        axios
          .get("/module/check-model", {
            params: { model_name: this.deleteModel },
          })
          .then((res) => {
            if (res.data) {
              (this.moduleNotExist = ""), (this.deleteButton = true);
            } else {
              this.deleteButton = false;
              this.moduleNotExist = "Module Not Exist";
            }
          });
      }, 600);
    },
  },
  created() {
    this.$store.dispatch("breadcrumb/storeLevels", breadcrumb);
  },

  // validation rule for form
  validators: {
    "data.model_name": function (value = null) {
      var app = this;
      return Validator.value(value)
        .required("Model Name is required")
        .minLength(3)
        .regex("^[a-zA-Z_]*$", "Must only contain alphabetic characters.")
        .regex("(?=.*?[A-Z])", "at least one uppercase letter required")
        .regex("(?=.*?[a-z])", "at least one lowercase letter required")
        .custom(function () {
          if (!Validator.isEmpty(value)) {
            app.disabled = true;
            axios
              .get("/module/check-model", {
                params: { model_name: app.data.model_name },
              })
              .then((res) => {
                if (res.data) {
                  app.model_exist = true;
                } else {
                  app.model_exist = false;
                }
              });
            return Promise.delay(1500).then(function () {
              if (app.model_exist) {
                return "Model name already exists";
              }
              app.disabled = false;
            });
          }
        });
    },
  },
};
</script>

<style>
.capitalize {
  text-transform: capitalize;
}
div#vs1__combobox {
  height: 39px;
}
</style>
