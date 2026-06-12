<template>
  <ol :class="cn('flex w-full items-center gap-space-3', $attrs.class)">
    <li
      v-for="(step, index) in steps"
      :key="step.key || step.label || index"
      class="flex min-w-0 flex-1 items-center gap-space-3"
    >
      <span
        :class="cn(
          'flex h-7 w-7 shrink-0 items-center justify-center rounded-full border-[0.5px] text-xs font-medium',
          index < current
            ? 'border-primary bg-primary text-bg-page'
            : index === current
              ? 'border-primary bg-primary-tint text-primary'
              : 'border-border bg-bg-subtle text-text-tertiary'
        )"
      >
        <Check v-if="index < current" class="h-4 w-4" />
        <span v-else>{{ index + 1 }}</span>
      </span>
      <span class="min-w-0 truncate text-[13px] font-medium text-text-primary">
        {{ step.label || step }}
      </span>
      <span
        v-if="index < steps.length - 1"
        class="hidden h-px flex-1 bg-border sm:block"
      ></span>
    </li>
  </ol>
</template>

<script setup>
import { Check } from 'lucide-vue-next';
import { cn } from '@/lib/utils';

defineProps({
  steps: {
    type: Array,
    required: true
  },
  current: {
    type: Number,
    default: 0
  }
});
</script>
