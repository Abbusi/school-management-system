<template>
  <thead :class="cn('border-b-[0.5px] border-border', $attrs.class)">
    <slot />
  </thead>
</template>

<script setup>
import { cn } from '@/lib/utils';
</script>
