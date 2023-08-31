<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>

  <st-welcome />
  <st-count />
  <st-login-chart />

  <div class="block lg:flex">
    <st-announced />
    <st-peanutadmin />
  </div>
</template>

<script setup>
  import StCount from './components/st-count.vue'
  import StWelcome from './components/st-welcome.vue'
  import StLoginChart from './components/st-loginChart.vue'
  import StPeanutadmin from './components/st-peanutadmin.vue'
  import StAnnounced from './components/st-announced.vue'
</script>

