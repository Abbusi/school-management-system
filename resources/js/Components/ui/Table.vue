<template>
  <div class="w-full overflow-auto">
    <table :class="cn('w-full border-collapse text-left text-[13px]', $attrs.class)">
      <slot />
    </table>
  </div>
</template>

<script setup>
import { cn } from '@/lib/utils';
</script>
