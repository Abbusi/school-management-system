<template>
  <component
    :is="href ? Link : 'button'"
    :href="href || undefined"
    type="button"
    :class="cn(
      'flex w-full items-center gap-2 rounded-sm px-3 py-2 text-left text-[13px] text-text-secondary transition-colors hover:bg-bg-subtle hover:text-text-primary',
      danger && 'text-danger-text hover:bg-danger-bg hover:text-danger-text',
      disabled && 'pointer-events-none opacity-50',
      $attrs.class
    )"
    role="menuitem"
  >
    <slot />
  </component>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { cn } from '@/lib/utils';

defineProps({
  href: {
    type: String,
    default: ''
  },
  danger: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  }
});
</script>
