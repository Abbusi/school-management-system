<template>
  <th :class="cn('h-10 px-2.5 text-left align-middle font-sans font-medium text-text-secondary text-[11px] uppercase tracking-[0.06em]', $attrs.class)">
    <slot />
  </th>
</template>

<script setup>
import { cn } from '@/lib/utils';
</script>
