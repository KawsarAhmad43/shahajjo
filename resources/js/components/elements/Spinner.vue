<template>
  <div class="card-body d-flex align-items-center justify-content-center flex-column">
    <i class="fa fa-spinner fa-spin" style="font-size:24px;color: rgb(0, 127, 62);"></i>
    <span class="processing">processing</span>
  </div>
</template>

<script>
export default {};
</script>


<style lang="scss">
.loading-anime {
  position: relative;
  padding: 1.5rem 5rem;
  .shape {
    display: block;
    border-top: 20px solid transparent;
    border-left: 30px solid #f4f4f4;
    border-bottom: 20px solid transparent;
    &.shape1 {
      border-left: 30px solid #007f3d;
    }
    &.shape2 {
      border-left: 30px solid #6dc8be;
    }
    &.shape3 {
      position: absolute;
      top: 40px;
      margin-left: 20px;
      border-left: 30px solid #ed1c24;
    }
  }
}
/* loading dots */
.processing {
  font-size: 15px;
  margin-top: -50px;
}

.processing:after {
  content: ".";
  font-size: 70px;
  animation: dots 1s steps(5, end) infinite;
}

@keyframes dots {
  0%,
  20% {
    color: #ed1c24;
    text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
  }
  40% {
    color: #007f3d;
    text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
  }
  60% {
    text-shadow: 0.25em 0 0 #007f3d, 0.5em 0 0 rgba(0, 0, 0, 0);
  }
  80%,
  100% {
    text-shadow: 0.25em 0 0 #007f3d, 0.5em 0 0 #007f3d;
  }
}
</style>

