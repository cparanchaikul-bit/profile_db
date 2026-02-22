<template>
  <div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
      <div class="container">
        <a class="navbar-brand" href="/">ร้านขายของ</a>
        
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link class="nav-link" to="/">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/product">Product</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/Contact">Contact</router-link>
            </li>

            <template v-if="isLoggedIn">
             

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Employees</a>
                <ul class="dropdown-menu">
                  <li><router-link class="dropdown-item" to="/employees">Employees</router-link></li>
                  <li><router-link class="dropdown-item" to="/employees_crud">Employees_crud</router-link></li>
                  <li><router-link class="dropdown-item" to="/employee_crud_image">Employees crud Image</router-link></li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Customer</a>
                <ul class="dropdown-menu">
                  <li><router-link class="dropdown-item" to="/Customer">Customer</router-link></li>
                  <li><router-link class="dropdown-item" to="/customer_crud">Customer_crud</router-link></li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Type</a>
                <ul class="dropdown-menu">
                  <li><router-link class="dropdown-item" to="/type">Type</router-link></li>
                  <li><router-link class="dropdown-item" to="/type_crud">Type_crud</router-link></li>
                </ul>
              </li>
              
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Product Admin</a>
                <ul class="dropdown-menu">
                  <li><router-link class="dropdown-item" to="/show_product">Show_product</router-link></li>
                  <li><router-link class="dropdown-item" to="/product_crud">Product Crud</router-link></li>
                  <li><router-link class="dropdown-item" to="/product_api">Product_api</router-link></li>
                </ul>
              </li>
            </template>
          </ul>

          <div class="d-flex align-items-center">
            <span v-if="isLoggedIn" class="me-3 text-light">
              👤 <span class="badge bg-success">{{ userName }}</span>
            </span>

            <router-link v-if="!isLoggedIn" to="/login" class="btn btn-primary">Login</router-link>
            <button v-if="isLoggedIn" @click="logout" class="btn btn-danger ms-2">Logout</button>
          </div>
        </div>
      </div>
    </nav>

    <router-view />
  </div>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: false,
      userName: ""
    }
  },
  mounted() {
    this.checkLogin()
  },
  methods: {
    checkLogin() {
      // ตรวจสอบสถานะจาก localStorage
      this.isLoggedIn = !!localStorage.getItem("adminLogin")
      if (this.isLoggedIn) {
        const user = JSON.parse(localStorage.getItem("user"))
        this.userName = user?.name || "Admin"
      }
    },
    logout() {
      localStorage.removeItem("adminLogin")
      localStorage.removeItem("user")
      this.isLoggedIn = false
      this.userName = ""
      this.$router.push("/login")
    }
  },
  watch: {
    // เมื่อเปลี่ยน URL ให้เช็คสถานะใหม่ทุกครั้ง
    '$route'() {
      this.checkLogin()
    }
  }
}
</script>