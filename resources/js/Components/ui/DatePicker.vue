<template>
  <div class="relative">
    <CalendarDays class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-text-tertiary" />
    <input
      type="date"
      :value="modelValue"
      :disabled="disabled"
      :class="cn(
        'flex h-9 w-full rounded-sm border-[0.5px] border-border bg-bg-card py-2 pl-9 pr-3 text-[13px] text-text-primary focus-visible:border-primary focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50',
        $attrs.class
      )"
      @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>

<script setup>
import { CalendarDays } from 'lucide-vue-next';
import { cn } from '@/lib/utils';

defineProps({
  modelValue: {
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
