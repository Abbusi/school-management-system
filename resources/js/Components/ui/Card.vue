<template>
  <div
    :class="cn(
      variant === 'stat' 
        ? 'bg-bg-subtle rounded-sm p-[12px] px-[16px]' 
        : 'bg-bg-card border-[0.5px] border-border rounded-md p-5',
      $attrs.class
    )"
  >
    <slot />
  </div>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  variant: {
    type: String,
    default: 'default' // 'default' or 'stat'
  }
});
</script>
