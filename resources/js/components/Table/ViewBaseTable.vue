<template>
  <!-- content part start -->
  <div class="view-page">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div
            class="col-xl-3"
            v-if="
              (Array.isArray(fileColumns) && fileColumns.length > 0) ||
              loop(data, 10) === 1
            "
          >
            <div v-for="(file, inx) in fileColumns" :key="inx">
              <span v-for="(value, key) in data" :key="key">
                <div class="left-info mt-2" v-if="checkTrue(file.field, key)">
                  <div class="file" v-if="file.field == key">
                    <img
                      :src="
                        value.includes('pdf')
                          ? $root.baseurl + '/images/pdf.png'
                          : value
                      "
                      alt="prf"
                      class="img-fluid w-100"
                      :style="
                        !value.includes('pdf')
                          ? ''
                          : 'height: 50px;width: 50px !important;overflow: hidden;display: block;margin-left: 80px;'
                      "
                    />
                    <a :href="value" download v-if="value.includes('pdf')"
                      ><i class="fa-solid fa-download"></i> Download
                    </a>
                  </div>
                </div>
              </span>
            </div>
          </div>

          <template v-if="typeof fields !== 'undefined'">
            <div
              :class="
                Array.isArray(fileColumns) && fileColumns.length > 0
                  ? 'col-xl-9'
                  : 'col-xl-6'
              "
              :key="index"
            >
              <table class="table table-bordered">
                <tbody>
                  <!----------- Belongs to ----------->
                  <template
                    v-if="belongs_to && belongs_to.data && belongs_to.fields"
                  >
                    <template
                      v-for="(item, index) in belongs_to.fields"
                      :key="index"
                    >
                      <tr>
                        <th class="text-capitalize">
                          {{ index !== 0 ? item : "Parent" }}:
                        </th>
                        <td class="text-capitalize">
                          <template v-if="index !== 0">
                            {{ belongs_to.data[item] }}
                          </template>

                          <template v-else>
                            <a
                              :href="`${$root.baseurl}/${belongs_to.model}/${belongs_to.data.id}`"
                              >{{ belongs_to.data[item] }}</a
                            >
                          </template>
                        </td>
                      </tr>
                    </template>
                  </template>
                  <!----------- Belongs to ----------->

                  <tr v-for="(item, name) in fields" :key="'A' + name">
                    <slot v-if="item !== 'image'">
                      <slot v-if="item !== 'file'">
                        <th
                          class="text-capitalize"
                          v-if="typeof item == 'string'"
                        >
                          {{ item.replace(new RegExp("_", "g"), " ") }}:
                        </th>
                        <!-- <th v-if="typeof item == 'string'">:</th> -->
                        <td class="text-capitalize">
                          <span v-if="item == 'created_at'">
                            {{
                              data[item] ? $filter.enFormat(data[item]) : "N/A"
                            }}
                          </span>

                          <span v-else-if="item == 'updated_at'">
                            {{ $filter.enFormat(data[item]) }}
                          </span>

                          <span v-else-if="item == 'image'">
                            <img :src="data[item]" width="100" />
                          </span>
                          <span v-else-if="item == 'img'">
                            <img :src="data[item]" width="100" />
                          </span>
                          <span v-else-if="item == 'thumbnail'">
                            <img :src="data[item]" width="100" />
                          </span>
                          <span v-else-if="item == 'thumb'">
                            <img :src="data[item]" width="100" />
                          </span>
                          <span v-else-if="item == 'logo'">
                            <img :src="data[item]" width="100" />
                          </span>
                          <span v-else-if="item == 'url'">
                            <iframe
                              :src="data[item]"
                              width="600"
                              height="400"
                            ></iframe>
                          </span>

                          <span v-else>
                            {{ data[item] }}
                          </span>
                        </td>
                      </slot>
                    </slot>
                  </tr>
                </tbody>
              </table>
            </div>
          </template>

          <template v-else>
            <div
              :class="
                Array.isArray(fileColumns) && fileColumns.length > 0
                  ? 'col-xl-9'
                  : 'col-xl-6'
              "
              v-for="(slicedData, index) in sliceData(data, 10)"
              :key="index"
            >
              <table class="table table-bordered">
                <tbody>
                  <!----------- Belongs to ----------->
                  <template
                    v-if="belongs_to && belongs_to.data && belongs_to.fields"
                  >
                    <template
                      v-for="(item, index) in belongs_to.fields"
                      :key="index"
                    >
                      <tr>
                        <th class="text-capitalize">
                          {{ index !== 0 ? item : "Parent" }}:
                        </th>
                        <td class="text-capitalize">
                          <template v-if="index !== 0">
                            {{ belongs_to.data[item] }}
                          </template>

                          <template v-else>
                            <a
                              :href="`${$root.baseurl}/${belongs_to.model}/${belongs_to.data.id}`"
                              >{{ belongs_to.data[item] }}</a
                            >
                          </template>
                        </td>
                      </tr>
                    </template>
                  </template>
                  <!----------- Belongs to ----------->

                  <tr v-for="(item, name) in slicedData" :key="'A' + name">
                    <slot v-if="!name.includes('image')">
                      <slot v-if="!name.includes('file')">
                        <th
                          class="text-capitalize"
                          v-if="typeof item == 'string'"
                        >
                          {{ name.replace(new RegExp("_", "g"), " ") }}:
                        </th>
                        <!-- <th v-if="typeof item == 'string'">:</th> -->
                        <td
                          class="text-capitalize"
                          v-if="typeof item == 'string'"
                        >
                          <span v-if="name == 'created_at'">
                            {{ $filter.enFormat(item) }}
                          </span>
                          <span v-else-if="name == 'updated_at'">
                            {{ $filter.enFormat(item) }}
                          </span>
                          <span v-else-if="name.includes('image')">
                            <img :src="item" width="100" />
                            <a target="_blank" :href="item">Image Link</a>
                          </span>
                          <span v-else-if="name.includes('profile')">
                            <img :src="item" width="100" />
                          </span>
                          <span v-else-if="name.includes('img')">
                            <img :src="item" width="100" />
                            <a target="_blank" :href="item">Image Link</a>
                          </span>
                          <span v-else-if="name.includes('thumbnail')">
                            <img :src="item" width="100" />
                            <!-- <a target="_blank" :href="item">Image Link</a> -->
                          </span>
                          <span v-else-if="name.includes('thumb')">
                            <img :src="item" width="100" />
                            <!-- <a target="_blank" :href="item">Image Link</a> -->
                          </span>
                          <span v-else-if="name.includes('logo')">
                            <img :src="item" width="100" />
                            <!-- <a target="_blank" :href="item">Image Link</a> -->
                          </span>
                          <span v-else-if="name.includes('url')">
                            <iframe
                              :src="item"
                              width="600"
                              height="400"
                            ></iframe>
                            <!-- <a target="_blank" :href="item">Image Link</a> -->
                          </span>
                          <span v-else-if="name.includes('file')">
                            <!-- <iframe :src="item" width="700"></iframe> -->
                            <!-- <a target="_blank" :href="item">File Link</a> -->
                          </span>
                          <span v-else-if="name == 'date'">{{
                            $filter.enFormat(item)
                          }}</span>
                          <span v-else> <span v-html="item"></span></span>
                        </td>
                      </slot>
                    </slot>
                  </tr>
                </tbody>
              </table>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>

  <!-- content part end -->
</template>

<script>
export default {
  setup() {},
  props: ["data", "fileColumns", "belongs_to", "fields"],
  methods: {
    checkTrue(field, index) {
      return field == index ? true : false;
    },
    loop(data, pieces) {
      if (data) {
        const count = Object.keys(data).length / pieces;
        return count > 1 ? count : 1;
      }
    },
    sliceData(obj, pieces) {
      const result = [];
      const keys = Object.keys(obj);
      const rowspan = Math.ceil(keys.length / pieces);
      const size = Math.ceil(keys.length / rowspan);

      for (let i = 0; i < keys.length; i += size) {
        const slice = {};
        for (let j = i; j < i + size && j < keys.length; j++) {
          slice[keys[j]] = obj[keys[j]];
        }
        result.push(slice);
      }
      return result;
    },
  },
};
</script>

<style scoped>
table th {
  text-align: right !important;
  width: 50%;
  font-size: 13px;
}

table td {
  text-align: left !important;
  width: 50%;
  font-size: 13px;
}
</style>
