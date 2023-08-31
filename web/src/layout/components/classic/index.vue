<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <a-layout class="layout flex justify-between h-full">

    <pa-classic-slider class="pa-ui-slider" />

    <a-layout-content class="flex flex-col">
      <pa-classic-header class="pa-ui-header" />
      <pa-worker-area />
    </a-layout-content>

  </a-layout>
</template>

<script setup>
import { ref } from 'vue'

import PaClassicSlider from './pa-classic-slider.vue'
import PaClassicHeader from './pa-classic-header.vue'
import PaWorkerArea from '../pa-workerArea.vue'

</script>
