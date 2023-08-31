<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->

<template>
  <a-layout-header class="layout-header flex flex-col operation-area">
    <div class="flex justify-between" style="height: 50px;">
      <a-avatar class="mt-1 ml-2 inline lg:hidden" style="width:45px;" :size="40"><img :src="`${$url}logo.svg`" class="bg-white" /></a-avatar>
      <pa-breadcrumb />
      <pa-operation />
    </div>
    <pa-tags class="hidden lg:flex" />
  </a-layout-header>
</template>

<script setup>
  import PaBreadcrumb from '../pa-breadcrumb.vue'
  import PaOperation from '../pa-operation.vue'
  import PaTags from '../pa-tags.vue'
</script>
