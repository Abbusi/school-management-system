<template>
  <div
    :class="cn(
      'rounded-full bg-bg-subtle text-text-secondary font-medium flex items-center justify-center overflow-hidden shrink-0 select-none border-[0.5px] border-border',
      size === 'sm' ? 'w-[28px] h-[28px] text-[10px]' :
      size === 'lg' ? 'w-[40px] h-[40px] text-[14px]' :
      'w-[32px] h-[32px] text-[12px]',
      $attrs.class
    )"
  >
    <img
      v-if="src && !hasError"
      :src="src"
      :alt="alt"
      @error="hasError = true"
      class="w-full h-full object-cover"
    />
    <span v-else>{{ initials || 'U' }}</span>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps({
  src: {
    type: String,
    default: ''
  },
  alt: {
    type: String,
    default: ''
  },
  initials: {
    type: String,
    default: 'U'
  },
  size: {
    type: String,
    default: 'md' // sm, md, lg
  }
});

const hasError = ref(false);

watch(() => props.src, () => {
  hasError.value = false;
});
</script>
