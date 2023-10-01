<template>
    <div v-if="isLoading" class="row col" >
        <div>
            <b-spinner label=""></b-spinner>
            <p>Loading...</p>
        </div>
    </div>
</template>

<script>
export default {
  name: "Loading",
  props: {
    isLoading: {
      type: Boolean,
      required: true
    }
  }
};
</script>
