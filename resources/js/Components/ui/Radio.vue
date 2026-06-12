<template>
  <label class="inline-flex cursor-pointer select-none items-center gap-space-2">
    <input
      type="radio"
      :name="name"
      :value="value"
      :checked="modelValue === value"
      :disabled="disabled"
      class="sr-only"
      @change="$emit('update:modelValue', value)"
    />
    <span
      :class="cn(
        'flex h-4 w-4 items-center justify-center rounded-full border-[0.5px] transition-all duration-150',
        modelValue === value
          ? 'border-primary bg-primary'
          : 'border-border bg-bg-card hover:border-text-secondary',
        disabled && 'cursor-not-allowed opacity-50'
      )"
    >
      <span class="h-1.5 w-1.5 rounded-full bg-bg-page"></span>
    </span>
    <span v-if="$slots.default" class="text-[13px] text-text-primary">
      <slot />
    </span>
  </label>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  modelValue: {
    type: [String, Number, Boolean],
    default: null
  },
  value: {
    type: [String, Number, Boolean],
    required: true
  },
  name: {
    type: String,
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  }
});

defineEmits(['update:modelValue']);
</script>
