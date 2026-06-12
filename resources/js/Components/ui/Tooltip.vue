<template>
  <span class="group relative inline-flex">
    <slot />
    <span
      :class="cn(
        'pointer-events-none absolute z-40 whitespace-nowrap rounded-sm bg-text-primary px-2 py-1 text-[11px] font-medium text-bg-page opacity-0 shadow-sm transition-opacity duration-150 group-hover:opacity-100 group-focus-within:opacity-100',
        positionClasses[position] || positionClasses.top,
        $attrs.class
      )"
      role="tooltip"
    >
      <slot name="content">{{ content }}</slot>
    </span>
  </span>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  content: {
    type: String,
    default: ''
  },
  position: {
    type: String,
    default: 'top'
  }
});

const positionClasses = {
  top: 'bottom-full left-1/2 mb-2 -translate-x-1/2',
  bottom: 'left-1/2 top-full mt-2 -translate-x-1/2',
  left: 'right-full top-1/2 mr-2 -translate-y-1/2',
  right: 'left-full top-1/2 ml-2 -translate-y-1/2'
};
</script>
