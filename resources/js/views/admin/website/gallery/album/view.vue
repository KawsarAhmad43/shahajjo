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
                  <div class="col-xl-12">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th class="text-capitalize">Type</th>
                          <th>:</th>
                          <td>
                            <img
                              :src="data.image"
                              style="height: 100px !important"
                            />
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">Type</th>
                          <th>:</th>
                          <td>
                            <span>{{ data.type }}</span>
                          </td>
                        </tr>

                        <tr>
                          <th class="text-capitalize">Name</th>
                          <th>:</th>
                          <td>
                            <span>{{ data.name }}</span>
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">Slug</th>
                          <th>:</th>
                          <td>
                            <span
                              ><span>{{ data.slug }}</span></span
                            >
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">created at</th>
                          <th>:</th>
                          <td>
                            <span>{{ data.created_at }}</span>
                          </td>
                        </tr>
                        <tr>
                          <th class="text-capitalize">updated at</th>
                          <th>:</th>
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
      </div>
    </div>
  </div>
</template>

<script>
// define model name
const model = "album";

export default {
  data() {
    return {
      model: model,
      data: {},
    };
  },
  created() {
    this.setBreadcrumbs(this.model, "view");
    this.get_data(`${this.model}/${this.$route.params.id}`);
  },
};
</script>
