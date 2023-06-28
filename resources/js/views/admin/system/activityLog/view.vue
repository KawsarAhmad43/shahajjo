<template>
  <view-page :defaultTable="false">
    <div class="row">
      <div class="col-6">
        <div class="box box-danger" v-if="!$root.spinner">
          <div class="box-header with-border">
            <h3 class="box-title">Before process data</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <tbody>
                  <tr
                    v-for="(item, name) in data.properties.old"
                    :key="'A' + name"
                  >
                    <th class="text-capitalize" v-if="typeof item == 'string'">
                      {{ name.replace(new RegExp("_", "g"), " ") }}
                    </th>
                    <td v-if="typeof item == 'string'">
                      <span v-if="name == 'created_at'">{{
                        $filter.enFormat(item)
                      }}</span>
                      <span v-else-if="name == 'updated_at'">{{
                        $filter.enFormat(item)
                      }}</span>
                      <span v-else>{{ item }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="box box-success" v-if="!$root.spinner">
          <div class="box-header with-border">
            <h3 class="box-title">After process data</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <tbody>
                  <tr
                    v-for="(item, name) in data.properties.attributes"
                    :key="'A' + name"
                  >
                    <th class="text-capitalize" v-if="typeof item == 'string'">
                      {{ name.replace(new RegExp("_", "g"), " ") }}
                    </th>
                    <td v-if="typeof item == 'string'">
                      <span v-if="name == 'created_at'">{{
                        $filter.enFormat(item)
                      }}</span>
                      <span v-else-if="name == 'updated_at'">{{
                        $filter.enFormat(item)
                      }}</span>
                      <span v-else>{{ item }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </view-page>
</template>

<script>
// define model name
const model = "activityLog";

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