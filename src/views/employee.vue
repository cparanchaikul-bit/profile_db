<template>
  <div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #4a5568;">Employee List</h2>
    
    <div class="mb-3 text-start">
      <button class="btn btn-primary btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#employeeModal" @click="openAddModal">
        Add+
      </button>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle border-top shadow-sm">
        <thead style="background-color: #cfe2ff;">
          <tr class="text-dark">
            <th>รูปภาพ</th>
            <th>รหัส</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>ที่อยู่</th>
            <th>เบอร์โทรศัพท์</th>
            <th>แก้ไข/ลบ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="emp in employees" :key="emp.emp_id">
            <td>
              <img :src="'http://localhost/profile_db/php_api/' + emp.image" width="70" class="rounded shadow-sm">
            </td>
            <td class="text-secondary">{{ emp.emp_id }}</td>
            <td>{{ emp.first_name }}</td>
            <td>{{ emp.last_name }}</td>
            <td>{{ emp.address }}</td>
            <td>{{ emp.phone }}</td>
            <td>
              <button class="btn btn-warning btn-sm text-dark fw-bold px-3" data-bs-toggle="modal" data-bs-target="#employeeModal" @click="openEditModal(emp)">
                Edit
              </button>
              <span class="mx-1 text-muted">|</span>
              <button @click="deleteEmployee(emp.emp_id)" class="btn btn-danger btn-sm px-3">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header">
            <h5 class="modal-title w-100 text-center fw-bold">{{ isEdit ? 'Edit Employee' : 'Add Employee' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="mb-3"><input type="text" v-model="currentEmp.first_name" class="form-control" placeholder="First Name"></div>
            <div class="mb-3"><input type="text" v-model="currentEmp.last_name" class="form-control" placeholder="Last Name"></div>
            <div class="mb-3"><textarea v-model="currentEmp.address" class="form-control" placeholder="Address" rows="2"></textarea></div>
            <div class="mb-3"><input type="text" v-model="currentEmp.phone" class="form-control" placeholder="Phone"></div>
            <div class="mb-3">
              <label class="form-label small text-muted">เลือกรูปภาพพนักงาน</label>
              <input type="file" @change="onFileChange" class="form-control">
            </div>
            <div v-if="isEdit && currentEmp.image" class="mb-3 text-center">
               <img :src="'http://localhost/profile_db/php_api/' + currentEmp.image" width="100" class="rounded border">
            </div>
            <button @click="saveEmployee" class="btn btn-primary w-100 mb-2 py-2 fw-bold shadow-sm">
              {{ isEdit ? 'Update' : 'Add' }}
            </button>
            <button type="button" class="btn btn-outline-secondary w-100 py-2" data-bs-dismiss="modal" id="closeBtn">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      employees: [],
      isEdit: false,
      currentEmp: { emp_id: '', first_name: '', last_name: '', address: '', phone: '', image: '' },
      imageFile: null
    };
  },
  methods: {
    async getEmployees() {
      try {
        const res = await axios.get("http://localhost/profile_db/php_api/employees.php");
        this.employees = res.data;
      } catch (err) { console.error(err); }
    },
    onFileChange(e) { this.imageFile = e.target.files[0]; },
    openAddModal() {
      this.isEdit = false;
      this.imageFile = null;
      this.currentEmp = { emp_id: '', first_name: '', last_name: '', address: '', phone: '', image: '' };
    },
    openEditModal(emp) {
      this.isEdit = true;
      this.imageFile = null;
      this.currentEmp = { ...emp }; // โหลดข้อมูลแถวที่เลือกเข้า Modal
    },
    async saveEmployee() {
      const formData = new FormData();
      formData.append('emp_id', this.currentEmp.emp_id);
      formData.append('first_name', this.currentEmp.first_name);
      formData.append('last_name', this.currentEmp.last_name);
      formData.append('address', this.currentEmp.address);
      formData.append('phone', this.currentEmp.phone);
      if (this.imageFile) { formData.append('image', this.imageFile); }

      // ตรวจสอบชื่อไฟล์ให้ตรงกับในโฟลเดอร์ php_api
      const url = this.isEdit ? "edit_employee.php" : "add_employees.php";
      
      try {
        const res = await axios.post(`http://localhost/profile_db/php_api/${url}`, formData);
        if (res.data.success) {
          alert(this.isEdit ? "แก้ไขข้อมูลพนักงานสำเร็จ" : "เพิ่มพนักงานใหม่สำเร็จ");
          document.getElementById('closeBtn').click();
          this.getEmployees();
        }
      } catch (err) { alert("Network Error: ไม่สามารถบันทึกได้"); }
    },
    async deleteEmployee(id) {
      if (confirm(`คุณต้องการลบพนักงานรหัส ${id} ใช่หรือไม่?`)) { // ป๊อปอัพยืนยันการลบ
        try {
          const res = await axios.get(`http://localhost/profile_db/php_api/delete_employee.php?id=${id}`);
          if (res.data.success) { this.getEmployees(); }
        } catch (err) { console.error(err); }
      }
    }
  },
  mounted() { this.getEmployees(); }
};
</script>