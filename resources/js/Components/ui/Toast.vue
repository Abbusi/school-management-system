<template>
  <div
    :class="cn(
      'flex w-full max-w-sm items-start gap-3 rounded-md border-[0.5px] bg-bg-card p-space-4 shadow-lg',
      variantClasses[variant] || variantClasses.info,
      $attrs.class
    )"
    role="status"
  >
    <component :is="iconComponent" class="mt-0.5 h-4 w-4 shrink-0" />
    <div class="min-w-0 flex-1">
      <div v-if="title" class="text-[13px] font-medium text-text-primary">{{ title }}</div>
      <div class="text-[13px] text-text-secondary">
        <slot />
      </div>
    </div>
    <button
      v-if="dismissible"
      type="button"
      class="-m-1 rounded-sm p-1 text-text-tertiary hover:bg-bg-subtle hover:text-text-primary"
      @click="$emit('dismiss')"
      aria-label="Dismiss"
    >
      <X class="h-4 w-4" />
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { AlertCircle, CheckCircle2, Info, TriangleAlert, X } from 'lucide-vue-next';
import { cn } from '@/lib/utils';

const props = defineProps({
  title: {
    type: String,
    default: ''
  },
  variant: {
    type: String,
    default: 'info'
  },
  dismissible: {
    type: Boolean,
    default: true
  }
});

defineEmits(['dismiss']);

const variantClasses = {
  info: 'border-info/20',
  success: 'border-success/20',
  warning: 'border-warning/20',
  danger: 'border-danger/20'
};

const icons = {
  info: Info,
  success: CheckCircle2,
  warning: TriangleAlert,
  danger: AlertCircle
};

const iconComponent = computed(() => icons[props.variant] || Info);
</script>
