<template>
  <div class="container mt-4 text-center">
 

    <h2 class="mb-5" style="color: #4a5568;">Employee List</h2>
    
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col" v-for="emp in employees" :key="emp.emp_id">
        <div class="card h-100 shadow-sm border-0">
          <img 
            :src="'http://localhost/profile_db/php_api/' + emp.image" 
            class="card-img-top img-fluid p-2" 
            alt="Employee Image"
            style="object-fit: cover; height: 250px;"
          >
          <div class="card-body border-top">
            <h5 class="card-title fw-bold">{{ emp.first_name }} {{ emp.last_name }}</h5>
            <p class="card-text text-primary small fw-bold">
              Phone: {{ emp.phone }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading" class="mt-5"><p>กำลังโหลดข้อมูล...</p></div>
    <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ShowEmployees",
  data() {
    return {
      employees: [],
      loading: true,
      error: null
    };
  },
  methods: {
    async fetchEmployees() {
      try {
        // ดึงข้อมูลพนักงานทั้ง 5 รายการจากฐานข้อมูล profile_db
        const res = await axios.get("http://localhost/profile_db/php_api/employees.php");
        this.employees = res.data;
      } catch (err) {
        this.error = "เกิดข้อผิดพลาดในการดึงข้อมูล";
        console.error(err);
      } finally {
        this.loading = false;
      }
    }
  },
  mounted() {
    this.fetchEmployees();
  }
};
</script>

<style scoped>
.card {
  transition: transform 0.2s;
}
.card:hover {
  transform: translateY(-5px);
}
</style>