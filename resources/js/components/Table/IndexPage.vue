<template>
  <div class="content-part">
    <div v-if="!$root.spinner" class="inner-content">
      <div class="global-form">
        <div class="global-form-header">
          <div class="row">
            <!-- search form -->
            <div :class="button ? 'col-lg-10' : 'col-lg-12'">
              <slot name="left-side">
                <form v-on:submit.prevent="$parent.search">
                  <div class="row">
                    <slot name="search-field"></slot>

                    <Search
                      :fields_name="$parent.fields_name"
                      v-if="($parent.fields_name && searchBlock)"
                    />
                  </div>
                </form>
              </slot>
            </div>
            <!-- search form -->

            <!-- add or back button -->
            <slot name="button" v-if="button">
              <AddOrBackButton
                :route="$parent.model + '.create'"
                :portion="$parent.model"
                :icon="'plus'"
              />
            </slot>
            <!-- add or back button -->
          </div>
        </div>

        <!-- default -->
        <slot name="table-list"></slot>

        <!-- base-table -->
        <base-table v-if="defaultTable"></base-table>
        <!-- base-table -->

        <Pagination />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    defaultTable: {
      type: Boolean,
      default: true,
    },
    button: {
      type: Boolean,
      default: true,
    },
    searchBlock: {
      type: Boolean,
      default: true,
    },
  },
};
</script>