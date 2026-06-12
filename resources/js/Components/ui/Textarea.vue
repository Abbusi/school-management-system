<template>
  <textarea
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :disabled="disabled"
    :rows="rows"
    :class="cn(
      'flex min-h-[80px] w-full rounded-sm border-[0.5px] border-border bg-bg-card px-3 py-2 text-[13px] font-sans text-text-primary placeholder:text-text-tertiary focus-visible:outline-none focus-visible:border-primary disabled:cursor-not-allowed disabled:opacity-50 resize-y',
      $attrs.class
    )"
  ></textarea>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  rows: {
    type: [Number, String],
    default: 3
  },
  disabled: {
    type: Boolean,
    default: false
  }
});

defineEmits(['update:modelValue']);
</script>
