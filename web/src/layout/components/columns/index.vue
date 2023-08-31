<!--
 - PeanutAdmin is committed to providing solutions for quickly building web applications
-->
<template>
  <a-layout-content class="layout flex justify-between">
    <div id="layout-columns-left-panel" class="pa-ui-menu layout-columns-left-panel hidden lg:flex justify-between">
      <pa-columns-menu />
    </div>

    <div class="layout-columns-right-panel flex flex-col" :style="`width: calc(100% - ${containerWidth}px)`" >

      <pa-columns-header class="pa-ui-header" />
      <pa-worker-area />

    </div>
  </a-layout-content>
</template>
<script setup>
  import { onMounted, ref } from 'vue'
  import ResizeObserver from 'resize-observer-polyfill'
  import PaColumnsHeader from './pa-columns-header.vue'
  import PaColumnsMenu from './pa-columns-menu.vue'

  import PaWorkerArea from '../pa-workerArea.vue'

  const containerWidth = ref(0)

  onMounted(() => {
    const dom = document.getElementById('layout-columns-left-panel')
    const robserver = new ResizeObserver( entries => {
      for (const entry of entries) {
        // 可以通过 判断 entry.target得知当前改变的 Element，分别进行处理。
        switch(entry.target){
          case dom :
            containerWidth.value = entry.contentRect.width
          break
        }
      }
    })
    robserver.observe(dom)
  })
</script>
