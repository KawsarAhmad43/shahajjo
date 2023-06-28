<template>
  <div
    v-if="$root.tableSpinner"
    class="text-center"
    style="font-size: 17px; color: #adadad"
  >
    <span class="fa fa-circle-o-notch fa-spin"></span>
  </div>
</template>