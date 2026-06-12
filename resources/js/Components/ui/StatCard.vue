<template>
  <div
    :class="cn(
      'rounded-md border-[0.5px] border-border bg-bg-card p-space-5',
      $attrs.class
    )"
  >
    <div class="flex items-start justify-between gap-space-4">
      <div class="min-w-0">
        <p class="truncate text-[12px] font-medium uppercase tracking-normal text-text-tertiary">{{ label }}</p>
        <p class="mt-1 text-2xl font-medium text-text-primary">{{ value }}</p>
      </div>
      <div v-if="$slots.icon" class="rounded-sm bg-primary-tint p-space-2 text-primary">
        <slot name="icon" />
      </div>
    </div>
    <p v-if="meta || $slots.default" class="mt-space-3 text-[13px] text-text-secondary">
      <slot>{{ meta }}</slot>
    </p>
  </div>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  label: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  meta: {
    type: String,
    default: ''
  }
});
</script>
