<template>
    <div>
        <p v-if="!hasEmployee">
            No details for this employee id
        </p>
        <div v-if="hasEmployee" >
            <template>
            <div class="avator-holder">
                <b-avatar blank blank-color="#eee" size="6rem"></b-avatar>
            </div>
            </template>
            <h5 class="mt-0 mb-1">Name : {{ fullName }} </h5>
            <p class="mb-0">
            Address : {{ address ? address : "Address is not given" }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
  name: "MyInfo",
  props: {
    hasEmployee: {
        type: Boolean,
        required: true
    },
    fullName: {
        type : String,
        required: true
    },
    address : {
        type : String,
        required: true
    }
  }
};
</script>