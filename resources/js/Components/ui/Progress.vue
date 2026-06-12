<template>
  <div
    :class="cn(
      'w-full bg-bg-subtle rounded-full overflow-hidden',
      size === 'sm' ? 'h-1' : size === 'lg' ? 'h-2' : 'h-1.5',
      $attrs.class
    )"
  >
    <div
      class="bg-primary h-full rounded-full transition-all duration-300 ease-out"
      :style="{ width: `${clampedValue}%` }"
    ></div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps({
  value: {
    type: Number,
    default: 0
  },
  max: {
    type: Number,
    default: 100
  },
  size: {
    type: String,
    default: 'md' // sm, md, lg
  }
});

const clampedValue = computed(() => {
  const val = (props.value / props.max) * 100;
  return Math.min(Math.max(val, 0), 100);
});
</script>
