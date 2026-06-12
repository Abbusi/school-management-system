<template>
  <div class="relative inline-flex" ref="root">
    <button
      type="button"
      :class="cn(
        'inline-flex h-9 items-center gap-2 rounded-sm border-[0.5px] border-border bg-bg-card px-3 text-[13px] font-medium text-text-secondary transition-colors hover:bg-bg-subtle hover:text-text-primary',
        triggerClass
      )"
      @click="open = !open"
      :aria-expanded="open"
    >
      <slot name="trigger">Actions</slot>
      <ChevronDown class="h-4 w-4" />
    </button>
    <div
      v-if="open"
      :class="cn(
        'absolute top-full z-40 mt-2 min-w-44 rounded-md border-[0.5px] border-border bg-bg-card p-1 shadow-lg',
        align === 'end' ? 'right-0' : 'left-0',
        $attrs.class
      )"
      role="menu"
    >
      <slot :close="() => (open = false)" />
    </div>
  </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { ChevronDown } from 'lucide-vue-next';
import { cn } from '@/lib/utils';

defineProps({
  align: {
    type: String,
    default: 'start'
  },
  triggerClass: {
    type: String,
    default: ''
  }
});

const open = ref(false);
const root = ref(null);

function onClickOutside(event) {
  if (root.value && !root.value.contains(event.target)) {
    open.value = false;
  }
}

onMounted(() => document.addEventListener('click', onClickOutside));
onBeforeUnmount(() => document.removeEventListener('click', onClickOutside));
</script>
