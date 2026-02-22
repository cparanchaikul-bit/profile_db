<template>
  <div class="container my-5">
    <div v-if="loading" class="text-center">กำลังโหลด...</div>
    <div v-else-if="product" class="row">
      <div class="col-md-5">
        <img :src="'http://localhost/app-vue01/php_api/uploads/' + product.image" class="img-fluid rounded shadow" />
      </div>
      <div class="col-md-7">
        <h2 class="fw-bold">{{ product.product_name }}</h2>
        <h4 class="text-primary">{{ product.price }} บาท</h4>
        <p>{{ product.description }}</p>
        <div class="mt-4">
          <button class="btn btn-primary me-2">เพิ่มลงตะกร้า</button>
          <button @click="$router.back()" class="btn btn-outline-secondary">กลับ</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const product = ref(null);
const loading = ref(true);

onMounted(async () => {
  const id = route.query.id; // รับค่าจาก ?id=...
  try {
    const res = await fetch(`http://localhost/app-vue01/php_api/show_product_detail.php?id=${id}`);
    const result = await res.json();
    if (result.success) product.value = result.data;
  } finally { loading.value = false; }
});
</script>