<template>
  <label class="inline-flex items-center gap-space-2 cursor-pointer select-none">
    <input
      type="checkbox"
      :checked="modelValue"
      @change="$emit('update:modelValue', $event.target.checked)"
      :disabled="disabled"
      class="sr-only"
    />
    <div
      :class="cn(
        'w-9 h-5 rounded-pill p-[1.5px] transition-colors duration-150 ease-in-out border-[0.5px]',
        modelValue
          ? 'bg-primary border-primary'
          : 'bg-bg-subtle border-border',
        disabled && 'opacity-50 cursor-not-allowed'
      )"
    >
      <div
        :class="cn(
          'w-4 h-4 rounded-full bg-white transition-transform duration-150 ease-in-out',
          modelValue ? 'translate-x-[16px]' : 'translate-x-0'
        )"
      ></div>
    </div>
    <span v-if="$slots.default" class="text-[13px] font-sans text-text-primary">
      <slot />
    </span>
  </label>
</template>

<script setup>
import { cn } from '@/lib/utils';

defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  }
});

defineEmits(['update:modelValue']);
</script>
