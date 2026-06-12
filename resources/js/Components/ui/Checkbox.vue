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
        'w-4 h-4 rounded-sm border-[0.5px] flex items-center justify-center transition-all duration-120',
        modelValue
          ? 'bg-primary border-primary text-bg-page'
          : 'bg-bg-card border-border text-transparent hover:border-text-secondary',
        disabled && 'opacity-50 cursor-not-allowed'
      )"
    >
      <Check class="w-3 h-3 stroke-[3]" />
    </div>
    <span v-if="$slots.default" class="text-[13px] font-sans text-text-primary">
      <slot />
    </span>
  </label>
</template>

<script setup>
import { cn } from '@/lib/utils';
import { Check } from 'lucide-vue-next';

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
