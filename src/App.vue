<template>
  <div id="app">
    <nav class="navbar navbar-expand-lg bg-white">
      <div class="container justify-content-center">
        <div class="d-flex align-items-center mt-3">
          <router-link to="/add_employees" class="nav-link text-success px-2">Employee</router-link>
          <span class="mx-1">|</span>
          <router-link to="/employees" class="nav-link text-dark fw-bold px-2">Show Employee</router-link>
        </div>
      </div>
    </nav>
    <router-view />
  </div>
</template>

<style scoped>
.nav-link { font-size: 14px; text-decoration: none; }
</style>