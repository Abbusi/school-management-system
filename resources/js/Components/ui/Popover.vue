<template>
  <div class="relative inline-flex" ref="root">
    <button
      type="button"
      :class="triggerClass"
      @click="isOpen = !isOpen"
      :aria-expanded="isOpen"
    >
      <slot name="trigger" />
    </button>
    <div
      v-if="isOpen"
      :class="cn(
        'absolute z-40 mt-2 min-w-56 rounded-md border-[0.5px] border-border bg-bg-card p-space-4 shadow-lg',
        alignClasses[align] || alignClasses.start,
        $attrs.class
      )"
    >
      <slot />
    </div>
  </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { cn } from '@/lib/utils';

defineProps({
  align: {
    type: String,
    default: 'start'
  },
  triggerClass: {
    type: String,
    default: 'inline-flex'
  }
});

const isOpen = ref(false);
const root = ref(null);
const alignClasses = {
  start: 'left-0 top-full',
  center: 'left-1/2 top-full -translate-x-1/2',
  end: 'right-0 top-full'
};

function onClickOutside(event) {
  if (root.value && !root.value.contains(event.target)) {
    isOpen.value = false;
  }
}

onMounted(() => document.addEventListener('click', onClickOutside));
onBeforeUnmount(() => document.removeEventListener('click', onClickOutside));
</script>
