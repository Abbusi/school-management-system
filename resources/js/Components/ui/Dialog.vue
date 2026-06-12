<template>
  <Teleport to="body">
    <div
      v-if="open"
      class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
      <!-- Backdrop -->
      <div
        class="fixed inset-0 bg-[#18302C]/30 transition-opacity duration-150"
        @click="closeOnBackdrop ? $emit('update:open', false) : null"
      ></div>

      <!-- Modal Panel -->
      <div
        :class="cn(
          'relative w-full bg-bg-card border-[0.5px] border-border rounded-lg p-space-6 z-10 animate-zoomIn flex flex-col',
          size === 'sm' ? 'max-w-sm' : size === 'lg' ? 'max-w-2xl' : 'max-w-md',
          $attrs.class
        )"
      >
        <!-- Close Button -->
        <button
          @click="$emit('update:open', false)"
          class="absolute top-space-4 right-space-4 p-1.5 rounded-sm text-text-secondary hover:bg-bg-subtle hover:text-text-primary transition-colors focus:outline-none"
        >
          <X class="w-4 h-4" />
        </button>

        <slot />
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { cn } from '@/lib/utils';
import { X } from 'lucide-vue-next';

defineProps({
  open: {
    type: Boolean,
    required: true
  },
  size: {
    type: String,
    default: 'md' // sm, md, lg
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true
  }
});

defineEmits(['update:open']);
</script>

<style scoped>
@keyframes zoomIn {
  from { opacity: 0; transform: scale(0.96); }
  to { opacity: 1; transform: scale(1); }
}
.animate-zoomIn {
  animation: zoomIn 0.15s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
