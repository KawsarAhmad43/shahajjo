<template>
  <div class="content-part">
    <div v-if="!$root.spinner" class="inner-content">
      <div class="global-form">
        <div class="global-form-header">
          <div class="row">
            <!-- search form -->
            <div class="col-lg-10">
              <slot name="header"></slot>
            </div>
            <!-- search form -->

            <!-- add or back button -->
            <slot name="button">
              <AddOrBackButton
                :route="model + '.index'"
                :portion="model"
                :icon="'fas fa-backward'"
              />
            </slot>
            <!-- add or back button -->
          </div>
        </div>

        <div class="form-input-details">
          <div class="view-page">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-xl-3"></div>
                  <div class="col-xl-6">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th class="text-capitalize th-align-right">Title:</th>
                          <td class="th-align-left">
                            <span>{{ data.title }}</span>
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">Position:</th>
                          <td>
                            <span
                              ><span>{{ data.position }}</span></span
                            >
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">Width:</th>
                          <td>
                            <span
                              ><span>{{ data.width }}</span></span
                            >
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">Height:</th>
                          <td>
                            <span
                              ><span>{{ data.height }}</span></span
                            >
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">status:</th>
                          <td>
                            <span
                              ><span>{{ data.status }}</span></span
                            >
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">created at:</th>
                          <td>
                            <span>{{ data.created_at }}</span>
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">updated at:</th>
                          <td>
                            <span>{{ data.updated_at }}</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="gallery-list" v-if="Object.keys(data.details).length <= 0">
          <div class="row">
            <div class="col-sm-6 col-lg-4 col-xl-3">
              <div class="image border">
                <div class="text-center mt-5">
                  <h1 class="lead">No Data Avilable</h1>
                </div>
                <div class="gallary-blank">
                  <div class="info">
                    <div>
                      <router-link
                        :to="{
                          name: 'slider-details.create',
                          query: { id: data.id },
                        }"
                        title="View"
                        ><button
                          class="manage-gallery btn btn-lg btn-primary shadow-none mt-4"
                        >
                          +
                        </button>
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="gallery-list" v-if="Object.keys(data.details).length > 0">
          <div class="row">
            <div
              v-for="(item, index) in data.details"
              :key="index"
              class="col-sm-6 col-lg-4 col-xl-3"
            >
              <div class="image">
                <img :src="item.image" :alt="item.name" />
                <div class="overlay">
                  <div class="info">
                    <router-link
                      :to="{
                        name: 'slider-details.edit',
                        params: { id: item.id },
                        query: { page: $route.query.page },
                      }"
                      class="delete edit"
                      title="Edit"
                    >
                      <i class="fas fa-pencil-alt"> </i>
                    </router-link>

                    <button
                      @click="destroy(item.id, index)"
                      class="delete delete-btn"
                      title="Delete"
                    >
                      <i class="far fa-trash-alt"></i>
                    </button>
                    <div>
                      <!-- <router-link
                        :to="{
                          name: 'slider-details.create',
                          query: { id: data.slider_id },
                        }"
                        title="View"
                        ><button
                          class="manage-gallery btn btn-primary shadow-none mt-4"
                        >
                          {{ data.slider_id }}
                          Manage Slider
                        </button>
                      </router-link> -->
                    </div>
                    <h4>{{ item.name }}</h4>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="col-sm-6 col-lg-4 col-xl-3"
              v-if="Object.keys(data.details).length < data.max_image"
            >
              <div class="image border">
                <div class="gallary-blank">
                  <div class="info">
                    <div>
                      <router-link
                        :to="{
                          name: 'slider-details.create',
                          query: { id: data.id },
                        }"
                        title="View"
                        ><button
                          class="manage-gallery btn btn-lg btn-primary shadow-none mt-4"
                        >
                          +
                        </button>
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- modal -->
        <div
          class="modal fade"
          id="deleteModal"
          tabindex="-1"
          aria-labelledby="deleteModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-black" id="deleteModalLabel">
                  Are you sure want to delete this?
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <h6 class="mb-3 text-black">
                  Please confirm your login password
                </h6>
                <div class="d-flex justify-content-center">
                  <input
                    v-model="delete_password"
                    type="password"
                    placeholder="********"
                    class="form-control form-control-sm text-center border"
                    style="width: 350px"
                  />
                </div>
                <div class="d-flex justify-content-center">
                  <button
                    @click="deleteConfirm()"
                    type="button"
                    class="btn btn-success btn-sm text-white my-3"
                  >
                    <span v-if="$root.submit">
                      <i class="fa fa-spinner fa-spin"></i>
                      processing...
                    </span>
                    <span v-else> Confirm </span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// define model name
const model = "slider";

export default {
  data() {
    return {
      model: model,
      data: {},
    };
  },
  methods: {
    edit(id) {},
    async destroy(id, index) {
      const destroy = await this.destroy_data("slider-details", id);

      if (index !== -1) {
        this.data.details.splice(index, 1);
      }
    },
  },
  created() {
    this.setBreadcrumbs(this.model, "view");
    this.get_data(`${this.model}/${this.$route.params.id}`);
  },
};
</script>

<style scoped>
table th {
  text-align: right !important;
  width: 50%;
}

table td {
  text-align: left !important;
  width: 50%;
}
</style>
