<template>
  <button
    :type="type"
    :disabled="disabled"
    :class="cn(
      'inline-flex items-center justify-center font-sans font-medium text-[13px] rounded-sm transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/20 disabled:cursor-not-allowed disabled:opacity-60',
      // Sizes
      size === 'sm' ? 'px-3 py-1.5' : size === 'lg' ? 'px-6 py-3 text-sm' : 'px-[18px] py-2',
      // Variants
      variant === 'outline' ? 'bg-transparent text-text-secondary border-[0.5px] border-border hover:bg-bg-subtle active:scale-[0.98]' :
      variant === 'ghost' ? 'bg-bg-subtle text-primary border-[0.5px] border-border hover:bg-border/30 active:scale-[0.98]' :
      variant === 'danger' ? 'bg-danger text-white hover:opacity-90 active:scale-[0.98]' :
      variant === 'success' ? 'bg-success-bg text-success-text border-[0.5px] border-[#86CFA0] hover:bg-success-bg/80 active:scale-[0.98]' :
      variant === 'link' ? 'bg-transparent text-primary underline-offset-4 hover:underline p-0' :
      // Default (Primary)
      'bg-primary text-bg-page hover:bg-primary-strong active:scale-[0.98]',
      $attrs.class
    )"
  >
    <slot />
  </button>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  type: {
    type: String,
    default: 'button'
  },
  variant: {
    type: String,
    default: 'primary'
  },
  size: {
    type: String,
    default: 'default'
  },
  disabled: {
    type: Boolean,
    default: false
  }
});
</script>
