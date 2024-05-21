<script setup>
import { RouterLink } from "vue-router";
import useCart from '../services/cart';
import useCompare from '../services/compare';
import useWishlist from '../services/wishlist';

const { products } = defineProps(['products'])

function formatPrice(price) {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD', // Update with your currency
  }).format(price);
}
</script>
<template>
  <div class="row px-xl-5 pb-3">
    <template v-for="(data, key) in products" :key="key">
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card product-item border-0 shadow-sm rounded hover-effect">
          <div class="card-img-top position-relative overflow-hidden d-flex justify-content-center align-items-center">
            <img class="img-fluid" :src="data.image" alt="image" style=" object-fit: cover; height: 100%; width: 100%;" />
          </div>
          <div class="card-body px-3 py-2 d-flex flex-column justify-content-between">
            <div>
              <h6 class="text-truncate mb-1 text-dark font-weight-bold">{{ data.name }}</h6>
              <template v-if="data.rating">
                <span class="text-warning font-weight-bold">
                  <i class="fas fa-star"></i> {{ data.rating }}
                </span>
              </template>
            </div>
            <div class="d-flex justify-content-between mt-auto">
              <template v-if="data.discount !== null && data.status !== 0 && data.expire_date > new Date().toISOString()">
                <template v-if="data.type == 'Percentage'">
                  <h6 class="text-muted mb-0">{{ Number(data.discount) }}% off</h6>
                  <h6 class="text-primary font-weight-bold mb-0">{{ formatPrice(Number(data.sale_price)) }}</h6>
                </template>
                <template v-else>
                  <h6 class="text-primary font-weight-bold mb-0">{{ formatPrice(Number(data.sale_price) - Number(data.discount)) }}</h6>
                  <del class="text-muted mb-0">{{ formatPrice(Number(data.sale_price)) }}</del>
                </template>
              </template>
              <template v-else>
                <h6 class="text-primary font-weight-bold mb-0">{{ formatPrice(Number(data.sale_price)) }}</h6>
              </template>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between border-top px-3 py-2">
            <button @click="useWishlist().addWishlist({ id: data.p_id, name: data.name, image: data.image, salePrice: data.sale_price })" class="btn btn-sm text-primary p-0 icon-hover">
              <i class="fas fa-heart"></i>
            </button>
            <button @click="useCart().addCart(data.p_id)" class="btn btn-sm text-primary p-0 icon-hover">
              <i class="fas fa-shopping-cart"></i>
            </button>
            <button @click="useCompare(data.p_id)" class="btn btn-sm text-primary p-0 icon-hover">
              <i class="fas fa-balance-scale"></i>
            </button>
            <RouterLink :to="{ name: 'products', params: { slug: data.slug } }" class="btn btn-sm text-primary p-0 icon-hover">
              <i class="fas fa-eye"></i>
            </RouterLink>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<style>
.card.product-item {
  transition: transform 0.3s, box-shadow 0.3s;
}

.card.product-item:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.card-img-top img {
  transition: transform 0.3s;
}

.card-img-top img:hover {
  transform: scale(1.1);
}

.icon-hover i {
  transition: color 0.3s, transform 0.3s;
}

.icon-hover i:hover {
  color: #ff6347; /* Change to desired hover color */
  transform: scale(1.2);
}
</style>
