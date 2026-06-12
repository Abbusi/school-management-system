<template>
  <span
    :class="cn(
      'inline-flex items-center font-sans font-medium text-[11px] px-[10px] py-[3px] rounded-pill whitespace-nowrap',
      variant === 'active' || variant === 'primary' ? 'bg-primary text-bg-page' :
      variant === 'success' || variant === 'confirmed' ? 'bg-success-bg text-success-text' :
      variant === 'warning' || variant === 'pending' ? 'bg-warning-bg text-warning-text' :
      variant === 'danger' || variant === 'rejected' ? 'bg-danger-bg text-danger-text' :
      variant === 'info' || variant === 'new' ? 'bg-info-bg text-info-text' :
      // Default (archived/neutral)
      'bg-bg-subtle text-text-secondary',
      $attrs.class
    )"
  >
    <slot />
  </span>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  variant: {
    type: String,
    default: 'neutral'
  }
});
</script>
