<template>
  <Head title="Login" />

  <main class="min-h-screen bg-bg-page text-text-primary font-sans antialiased">
    <div class="grid min-h-screen lg:grid-cols-[minmax(0,1fr)_480px]">
      <section class="hidden lg:flex flex-col justify-between border-r-[0.5px] border-border bg-bg-card p-space-12">
        <div>
          <div class="flex items-center gap-space-2">
            <div class="flex h-[26px] w-[26px] items-center justify-center rounded-sm bg-brand-mint text-[13px] font-medium text-text-primary">
              S
            </div>
            <div>
              <p class="text-[14px] font-medium leading-tight">
                {{ institute.short_name || 'School MS' }}
              </p>
              <p class="mt-1 text-[11px] text-text-tertiary">
                {{ institute.name || 'School Management System' }}
              </p>
            </div>
          </div>
        </div>

        <div class="max-w-[520px]">
          <p class="mb-space-3 text-[11px] font-medium uppercase tracking-[0.08em] text-text-secondary">
            Administration
          </p>
          <h1 class="text-[30px] font-medium leading-tight tracking-normal text-text-primary">
            A calm workspace for school operations.
          </h1>
          <p class="mt-space-4 max-w-[60ch] text-[14px] leading-6 text-text-secondary">
            Manage students, attendance, classes, exams, staff records and school settings from one focused interface.
          </p>
        </div>

        <div class="grid grid-cols-3 gap-space-3">
          <div v-for="item in highlights" :key="item.label" class="rounded-sm border-[0.5px] border-border bg-bg-subtle p-space-4">
            <component :is="item.icon" class="mb-space-3 h-4 w-4 text-primary" />
            <p class="text-[13px] font-medium text-text-primary">{{ item.label }}</p>
            <p class="mt-1 text-[11px] leading-4 text-text-secondary">{{ item.text }}</p>
          </div>
        </div>
      </section>

      <section class="flex min-h-screen items-center justify-center px-space-6 py-space-12">
        <Card class="w-full max-w-[384px] p-space-6">
          <div class="mb-space-6">
            <div class="mb-space-5 flex items-center gap-space-2 lg:hidden">
              <div class="flex h-[26px] w-[26px] items-center justify-center rounded-sm bg-brand-mint text-[13px] font-medium text-text-primary">
                S
              </div>
              <span class="text-[14px] font-medium">{{ institute.short_name || 'School MS' }}</span>
            </div>
            <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-text-secondary">
              Sign in
            </p>
            <h2 class="text-[22px] font-medium leading-tight">Welcome back</h2>
            <p class="mt-2 text-[13px] text-text-secondary">
              Use your username and password to continue.
            </p>
          </div>

          <div v-if="flash.success || flash.error || flash.warning" class="mb-space-4">
            <div
              :class="[
                'rounded-sm border-[0.5px] p-space-3 text-[13px]',
                flash.success ? 'border-[#86CFA0] bg-success-bg text-success-text' :
                flash.warning ? 'border-[#E4B86B] bg-warning-bg text-warning-text' :
                'border-[#DC4640]/30 bg-danger-bg text-danger-text'
              ]"
            >
              {{ flash.success || flash.warning || flash.error }}
            </div>
          </div>

          <form class="space-y-space-4" @submit.prevent="submit">
            <div>
              <label class="mb-1.5 block text-[13px] font-medium text-text-primary" for="username">
                Username
              </label>
              <Input
                id="username"
                v-model="form.username"
                autofocus
                autocomplete="username"
                placeholder="username"
                :class="form.errors.username && 'border-danger'"
              />
              <p v-if="form.errors.username" class="mt-1.5 text-[12px] text-danger-text">
                {{ form.errors.username }}
              </p>
            </div>

            <div>
              <label class="mb-1.5 block text-[13px] font-medium text-text-primary" for="password">
                Password
              </label>
              <Input
                id="password"
                v-model="form.password"
                type="password"
                autocomplete="current-password"
                placeholder="password"
                :class="form.errors.password && 'border-danger'"
              />
              <p v-if="form.errors.password" class="mt-1.5 text-[12px] text-danger-text">
                {{ form.errors.password }}
              </p>
            </div>

            <div class="flex items-center justify-between gap-space-3">
              <label class="flex items-center gap-space-2 text-[13px] text-text-secondary">
                <input
                  v-model="form.remember"
                  type="checkbox"
                  class="h-4 w-4 rounded-sm border-border text-primary focus:ring-primary"
                />
                Remember me
              </label>
              <Link href="/forgot" class="text-[13px] font-medium text-primary hover:text-primary-strong">
                Forgot password
              </Link>
            </div>

            <Button class="w-full" type="submit" :disabled="form.processing">
              <LoaderCircle v-if="form.processing" class="mr-space-2 h-4 w-4 animate-spin" />
              <span>Sign in</span>
            </Button>
          </form>
        </Card>
      </section>
    </div>
  </main>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { BookOpen, CalendarCheck, GraduationCap, LoaderCircle } from 'lucide-vue-next';
import Button from '@/Components/ui/Button.vue';
import Card from '@/Components/ui/Card.vue';
import Input from '@/Components/ui/Input.vue';

const page = usePage();
const institute = computed(() => page.props.appSettings?.institute_settings || {});
const flash = computed(() => page.props.flash || {});

const form = useForm({
  username: '',
  password: '',
  remember: false,
});

const highlights = [
  { label: 'Students', text: 'Profiles, classes and registrations.', icon: GraduationCap },
  { label: 'Attendance', text: 'Daily student and staff tracking.', icon: CalendarCheck },
  { label: 'Academics', text: 'Subjects, exams and results.', icon: BookOpen },
];

const submit = () => {
  form.post('/login', {
    preserveScroll: true,
    onFinish: () => form.reset('password'),
  });
};
</script>
