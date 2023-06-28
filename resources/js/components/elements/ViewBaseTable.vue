<template>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <tbody>
        <tr v-for="(item, name) in data" :key="'A'+name">
          <th
            class="text-capitalize"
            v-if="typeof item=='string'"
          >{{name.replace(new RegExp('_', 'g')," ")}}</th>
          <td v-if="typeof item=='string'">
            <span v-if="name == 'created_at'">{{item|formatDate}}</span>
            <span v-else-if="name == 'updated_at'">{{item|formatDate}}</span>
            <span v-else-if="name == 'date'">{{item|formatDate}}</span>
            <span v-else>{{item}}</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["data"],
};
</script>

<style>
</style>