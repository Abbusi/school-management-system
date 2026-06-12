<template>
  <div
    :class="cn(
      'flex gap-3 rounded-sm border-[0.5px] p-space-4 text-[13px]',
      variantClasses[variant] || variantClasses.info,
      $attrs.class
    )"
    role="alert"
  >
    <component :is="iconComponent" class="mt-0.5 h-4 w-4 shrink-0" />
    <div class="min-w-0 flex-1">
      <div v-if="title" class="font-medium text-text-primary">{{ title }}</div>
      <div class="text-text-secondary">
        <slot />
      </div>
    </div>
    <button
      v-if="dismissible"
      type="button"
      class="-m-1 rounded-sm p-1 text-text-secondary hover:bg-bg-card/60 hover:text-text-primary"
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
    default: false
  }
});

defineEmits(['dismiss']);

const variantClasses = {
  info: 'border-info/20 bg-info-bg text-info-text',
  success: 'border-success/20 bg-success-bg text-success-text',
  warning: 'border-warning/20 bg-warning-bg text-warning-text',
  danger: 'border-danger/20 bg-danger-bg text-danger-text'
};

const icons = {
  info: Info,
  success: CheckCircle2,
  warning: TriangleAlert,
  danger: AlertCircle
};

const iconComponent = computed(() => icons[props.variant] || Info);
</script>
