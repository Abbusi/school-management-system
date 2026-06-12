<template>
  <div
    :class="cn(
      'flex flex-col items-center justify-center rounded-md border-[0.5px] border-dashed border-border bg-bg-card p-space-8 text-center',
      $attrs.class
    )"
  >
    <div class="mb-space-4 rounded-full bg-primary-tint p-space-3 text-primary">
      <slot name="icon">
        <Inbox class="h-6 w-6" />
      </slot>
    </div>
    <h3 v-if="title" class="text-sm font-medium text-text-primary">{{ title }}</h3>
    <p v-if="$slots.default" class="mt-1 max-w-sm text-[13px] text-text-secondary">
      <slot />
    </p>
    <div v-if="$slots.action" class="mt-space-5">
      <slot name="action" />
    </div>
  </div>
</template>

<script setup>
import { Inbox } from 'lucide-vue-next';
import { cn } from '@/lib/utils';

defineProps({
  title: {
    type: String,
    default: ''
  }
});
</script>
