<template>
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100">
      <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <h4 class="text-center mb-4">🔐 เข้าสู่ระบบผู้ดูแล</h4>

            <div class="mb-3">
              <label class="form-label">ชื่อผู้ใช้</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-person"></i>
                </span>
                <input 
                  v-model="username" 
                  type="text" 
                  class="form-control" 
                  placeholder="กรอกชื่อผู้ใช้"
                  @keyup.enter="login" 
                />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">รหัสผ่าน</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-lock"></i>
                </span>
                <input 
                  v-model="password" 
                  type="password" 
                  class="form-control"
                  placeholder="กรอกรหัสผ่าน" 
                  @keyup.enter="login" 
                />
              </div>
            </div>

            <button @click="login" class="btn btn-primary w-100" :disabled="loading">
              <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
              {{ loading ? 'กำลังตรวจสอบ...' : 'เข้าสู่ระบบ' }}
            </button>

            <div v-if="error" class="alert alert-danger mt-3 mb-0 text-center">
              {{ error }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "LoginView",
  data() {
    return {
      username: "",
      password: "",
      error: "",
      loading: false,
    };
  },
  methods: {
    async login() {
      this.error = "";

      // 1. ตรวจสอบความว่างเปล่า
      if (!this.username || !this.password) {
        this.error = "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน";
        return;
      }

      try {
        this.loading = true;

        // 2. ยิง API ไปที่ PHP
        const res = await axios.post(
          "http://localhost/app-vue01/php_api/login.php",
          {
            username: this.username,
            password: this.password,
          }
        );

        console.log("Login Response:", res.data);

        // 3. ตรวจสอบผลลัพธ์
        if (res.data.success) {
          // เก็บสถานะการ Login
          localStorage.setItem("adminLogin", "true");
          
          // เก็บข้อมูล User ที่ส่งมาจาก PHP
          if (res.data.user) {
            localStorage.setItem("user", JSON.stringify(res.data.user));
          }

          // ✅ เปลี่ยนเส้นทางไปที่ Product Crud
          // หมายเหตุ: ชื่อ 'product_crud' ต้องตรงกับ name ใน router/index.js
          this.$router.push("/product_crud").catch(err => {
            console.error("Navigation Error:", err);
            // ถ้าไปหน้า product_crud ไม่ได้ ให้ไปหน้าแรกแทนเพื่อไม่ให้หน้าขาว
            this.$router.push("/");
          });

        } else {
          // แสดงข้อความ Error จากฝั่ง PHP
          this.error = res.data.message || "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }

      } catch (err) {
        console.error("Axios Error:", err);
        this.error = "ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้";
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>