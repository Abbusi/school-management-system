<template>
  <Teleport to="body">
    <div v-if="open" class="fixed inset-0 z-50">
      <div
        class="absolute inset-0 bg-[#18302C]/30"
        @click="closeOnBackdrop ? $emit('update:open', false) : null"
      ></div>
      <aside
        :class="cn(
          'absolute flex h-full w-full max-w-md flex-col border-border bg-bg-card p-space-6 shadow-xl transition-transform',
          side === 'left' ? 'left-0 top-0 border-r-[0.5px]' : 'right-0 top-0 border-l-[0.5px]',
          $attrs.class
        )"
      >
        <button
          type="button"
          class="absolute right-space-4 top-space-4 rounded-sm p-1.5 text-text-secondary hover:bg-bg-subtle hover:text-text-primary"
          @click="$emit('update:open', false)"
          aria-label="Close"
        >
          <X class="h-4 w-4" />
        </button>
        <slot />
      </aside>
    </div>
  </Teleport>
</template>

<script setup>
import { X } from 'lucide-vue-next';
import { cn } from '@/lib/utils';

defineProps({
  open: {
    type: Boolean,
    required: true
  },
  side: {
    type: String,
    default: 'right'
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true
  }
});

defineEmits(['update:open']);
</script>
