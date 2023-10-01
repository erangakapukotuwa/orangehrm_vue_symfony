<template>
    <div v-if="hasError" class="row col" >
      <div class="alert alert-danger" role="alert" >
        {{ error ? error : "An unrecognized error" }}
      </div>
    </div>
</template>

<script>
export default {
  name: "ResponseError",
  props: {
    hasError: {
      type: Boolean,
      required: true
    },
    error: {
        type : String,
        required: true
    }
  }
};
</script>