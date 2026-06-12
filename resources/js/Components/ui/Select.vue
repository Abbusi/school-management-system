<template>
  <select
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
    :disabled="disabled"
    :class="cn(
      'flex h-9 w-full rounded-sm border-[0.5px] border-border bg-bg-card px-3 py-2 text-[13px] font-sans text-text-primary focus-visible:outline-none focus-visible:border-primary disabled:cursor-not-allowed disabled:opacity-50',
      $attrs.class
    )"
  >
    <slot />
  </select>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  modelValue: {
    type: [String, Number],
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  }
});

defineEmits(['update:modelValue']);
</script>
