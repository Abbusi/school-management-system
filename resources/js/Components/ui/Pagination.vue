<template>
  <nav v-if="links && links.length > 3" class="flex flex-wrap items-center gap-1 select-none" aria-label="Pagination">
    <template v-for="(link, key) in links" :key="key">
      <!-- Disabled state for null url -->
      <div
        v-if="link.url === null"
        class="px-3 py-1.5 text-[13px] font-sans font-medium text-text-tertiary border-[0.5px] border-border bg-transparent rounded-sm cursor-not-allowed select-none opacity-50"
        v-html="link.label"
      ></div>
      <!-- Link state -->
      <Link
        v-else
        :href="link.url"
        :class="cn(
          'px-3 py-1.5 text-[13px] font-sans font-medium rounded-sm border-[0.5px] border-border transition-all duration-120 active:scale-[0.98]',
          link.active
            ? 'bg-primary text-bg-page border-primary'
            : 'bg-bg-card text-text-secondary hover:bg-bg-subtle hover:text-text-primary'
        )"
        v-html="link.label"
      ></Link>
    </template>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { cn } from '@/lib/utils';

defineProps({
  links: {
    type: Array,
    required: true
  }
});
</script>
