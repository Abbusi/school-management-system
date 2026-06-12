<template>
  <span
    :class="cn(
      'inline-flex items-center gap-1 rounded-pill px-[10px] py-[3px] text-[11px] font-medium whitespace-nowrap',
      classes,
      $attrs.class
    )"
  >
    <span class="h-1.5 w-1.5 rounded-full bg-current opacity-70"></span>
    <slot>{{ label }}</slot>
  </span>
</template>

<script setup>
import { computed } from 'vue';
import { cn } from '@/lib/utils';

const props = defineProps({
  channel: {
    type: String,
    default: 'direct'
  },
  label: {
    type: String,
    default: ''
  }
});

const channelClasses = {
  shopify: 'bg-[#EAF6E8] text-[#2D6A2E]',
  woocommerce: 'bg-[#F0EAF7] text-[#5E3A8C]',
  youcan: 'bg-[#E8F1FD] text-[#255C9C]',
  whatsapp: 'bg-[#E7F8EE] text-[#16794A]',
  direct: 'bg-bg-subtle text-text-secondary'
};

const classes = computed(() => channelClasses[props.channel] || channelClasses.direct);
</script>
