<template>
  <tr :class="cn('hover:bg-bg-subtle/50 transition-colors', $attrs.class)">
    <slot />
  </tr>
</template>

<script setup>
import { cn } from '@/lib/utils';
</script>
