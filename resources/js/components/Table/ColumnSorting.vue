<template>
  <th class="sort-th" @click="sort(column)">
    {{ title }}
    <span v-if="column == columnSort">
      <i v-if="order == 'desc'" class="fa fa-sort-amount-desc pull-right"></i>
      <i v-else class="fa fa-sort-amount-asc pull-right sort"></i>
    </span>
    <i v-else class="fa fa-sort-amount-asc pull-right sort"></i>
  </th>
</template>

<script>
export default {
  name: "ColumnSorting",
  props: ["column", "title"],
  data() {
    return {
      columnSort: "",
      order: "desc",
    };
  },
  methods: {
    sort(field) {
      this.coloumSort = field;
      this.$parent.table.datas.sort(this.sortBy(field));
    },
    sortBy(property) {
      if (this.order === "desc") {
        this.order = "asc";
      } else {
        this.order = "desc";
      }
      const order = this.order;
      return function (a, b) {
        const varA =
          typeof a[property] === "string"
            ? a[property].toUpperCase()
            : a[property];
        const varB =
          typeof b[property] === "string"
            ? b[property].toUpperCase()
            : b[property];

        let comparison = 0;
        if (varA > varB) comparison = 1;
        else if (varA < varB) comparison = -1;
        return order === "desc" ? comparison * -1 : comparison;
      };
    },
  },
};
</script>