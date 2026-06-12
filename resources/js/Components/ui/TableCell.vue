<template>
  <td :class="cn('p-2.5 align-middle font-sans border-b-[0.5px] border-bg-subtle text-text-primary', $attrs.class)">
    <slot />
  </td>
</template>

<script setup>
import { cn } from '@/lib/utils';
</script>
