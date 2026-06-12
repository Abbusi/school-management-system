<template>
  <div
    :class="cn(
      'animate-pulse rounded-sm bg-bg-subtle',
      circle ? 'rounded-full' : '',
      $attrs.class
    )"
    :style="{ width, height }"
    aria-hidden="true"
  ></div>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  width: {
    type: String,
    default: '100%'
  },
  height: {
    type: String,
    default: '16px'
  },
  circle: {
    type: Boolean,
    default: false
  }
});
</script>
