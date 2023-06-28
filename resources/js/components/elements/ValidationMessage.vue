<template>
  <div
    class="modal fade"
    id="validateModal"
    tabindex="-1"
    aria-labelledby="validateModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-black" id="validateModalLabel">
            You need to fill empty mandatory fields
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
            v-if="
              $root.validation_errors &&
              Object.keys($root.validation_errors).length > 0
            "
            class="col-12 py-2 mb-3"
            style="background: #fddede"
          >
            <div class="error p-2">
              <span
                v-for="(err, errIndex) in $root.validation_errors"
                :key="errIndex"
                class="text-danger"
              >
                {{ err[0] }}
                <br />
              </span>
            </div>
          </div>

          <!-- exception_errors -->
          <div
            v-if="
              $root.exception_errors &&
              Object.keys($root.exception_errors).length > 0
            "
            class="col-12 py-2 mb-3"
            style="background: #fddede"
          >
            <div class="error p-2">
              <slot v-if="typeof $root.exception_errors === 'object'">
                <slot v-for="(err, errIndex) in $root.exception_errors">
                  <span
                    v-if="typeof err === 'string'"
                    :key="errIndex"
                    class="text-danger"
                  >
                    {{ err }}
                    <br />
                  </span>
                </slot>
              </slot>
              <slot v-else>
                {{ $root.exception_errors }}
              </slot>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>