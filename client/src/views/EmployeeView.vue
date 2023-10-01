<template>
  <div>
    <Loading :isLoading="isLoading" />
    <ResponseError v-if="hasError" :hasError="hasError" :error="error" />
      <h2>Dashboard</h2>
      <b-tabs content-class="mt-3">
        <b-tab title="My Info" active>
          <div class="tab-container">
            <MyInfo :hasEmployee="hasEmployee" :fullName="fullName" :address="employee.address"/>
          </div>
        </b-tab>
        <b-tab title="Employee Data">
          <div class="tab-container">
            <EmployeeData />
          </div>
        </b-tab>
        <b-tab title="Leave">
          <div class="tab-container">
            <LeaveData />
          </div>
        </b-tab>
      </b-tabs>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import MyInfo from '@/components/employee/MyInfo.vue'
import EmployeeData from '@/components/employee/EmployeeData.vue'
import LeaveData from '@/components/employee/LeaveData.vue'
import Loading from '@/components/common/Loading.vue'
import ResponseError from '@/components/common/ResponseError.vue'

export default {
  name: "Employee",

  components: {
    MyInfo,
    EmployeeData,
    LeaveData,
    Loading,
    ResponseError
  },
  data() {
    return {
      
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["employee/isLoading"];
    },
    hasError() {
      return this.$store.getters["employee/hasError"];
    },
    error() {
      return this.$store.getters["employee/error"];
    },
    hasEmployee() {
      return this.$store.getters["employee/hasEmployee"];
    },
    employee() {
      return this.$store.getters["employee/employee"];
    },
    fullName() {
      return this.$store.getters["employee/fullName"];
    }
  },
  created() {
    this.$store.dispatch("employee/findOne");
  }
};
</script>

<style>
.tab-container{
  padding: 30px 0px 60px 0px;
}
.avator-holder {
    float: left;
    margin-right: 20px;
  }
</style>
