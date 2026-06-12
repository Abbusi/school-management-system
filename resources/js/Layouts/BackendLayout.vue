<template>
  <div class="min-h-screen bg-bg-page text-text-primary font-sans flex antialiased">
    <aside class="w-[264px] bg-bg-card border-r-[0.5px] border-border flex flex-col fixed inset-y-0 left-0 z-20 overflow-y-auto">
      <div class="p-space-6 pb-space-4 border-b-[0.5px] border-bg-subtle">
        <div class="flex items-center gap-space-2 mb-space-1">
          <div class="w-[26px] h-[26px] bg-brand-mint rounded-sm flex items-center justify-center font-medium text-sm overflow-hidden select-none">
            <span class="text-text-primary">S</span>
          </div>
          <span class="font-medium text-sm text-text-primary truncate">
            {{ appSettings?.institute_settings?.short_name || 'School MS' }}
          </span>
        </div>
        <p class="text-[11px] text-text-tertiary font-medium leading-4 line-clamp-2">
          {{ appSettings?.institute_settings?.name || 'School Management System' }}
        </p>
      </div>

      <nav class="flex-1 p-space-4 space-y-space-5 select-none">
        <div v-for="section in visibleMenu" :key="section.label">
          <h3 class="text-[11px] font-medium text-text-secondary uppercase tracking-[0.08em] mb-space-2 px-space-2">
            {{ section.label }}
          </h3>

          <div class="space-y-[3px]">
            <template v-for="item in section.items" :key="item.label">
              <Link
                v-if="!item.children"
                :href="item.href"
                :class="navLinkClass(item)"
              >
                <component :is="item.icon" class="w-4 h-4 shrink-0" />
                <span class="truncate">{{ item.label }}</span>
              </Link>

              <details v-else class="group" :open="isGroupOpen(item)">
                <summary
                  :class="cn(
                    'flex items-center gap-space-2 px-space-2 py-1.5 rounded-sm text-[13px] cursor-pointer list-none transition-all duration-120',
                    isGroupActive(item)
                      ? 'bg-bg-subtle text-primary font-medium'
                      : 'text-text-secondary hover:bg-bg-subtle hover:text-text-primary'
                  )"
                >
                  <component :is="item.icon" class="w-4 h-4 shrink-0" />
                  <span class="truncate flex-1">{{ item.label }}</span>
                  <ChevronRight class="w-3.5 h-3.5 shrink-0 transition-transform group-open:rotate-90" />
                </summary>

                <div class="mt-1 ml-[15px] pl-space-3 border-l-[0.5px] border-bg-subtle space-y-[2px]">
                  <template v-for="child in item.children" :key="child.label">
                    <Link
                      v-if="!child.children"
                      :href="child.href"
                      :class="navChildClass(child)"
                    >
                      <component :is="child.icon || Circle" class="w-3.5 h-3.5 shrink-0" />
                      <span class="truncate">{{ child.label }}</span>
                    </Link>

                    <details v-else class="group/nested" :open="isGroupOpen(child)">
                      <summary
                        :class="cn(
                          'flex items-center gap-space-2 px-space-2 py-1.5 rounded-sm text-[12px] cursor-pointer list-none transition-all duration-120',
                          isGroupActive(child)
                            ? 'bg-bg-subtle text-primary font-medium'
                            : 'text-text-secondary hover:bg-bg-subtle hover:text-text-primary'
                        )"
                      >
                        <component :is="child.icon || Circle" class="w-3.5 h-3.5 shrink-0" />
                        <span class="truncate flex-1">{{ child.label }}</span>
                        <ChevronRight class="w-3 h-3 shrink-0 transition-transform group-open/nested:rotate-90" />
                      </summary>

                      <div class="mt-1 ml-[13px] pl-space-3 border-l-[0.5px] border-bg-subtle space-y-[2px]">
                        <Link
                          v-for="nested in child.children"
                          :key="nested.label"
                          :href="nested.href"
                          :class="navNestedClass(nested)"
                        >
                          <component :is="nested.icon || Circle" class="w-3 h-3 shrink-0" />
                          <span class="truncate">{{ nested.label }}</span>
                        </Link>
                      </div>
                    </details>
                  </template>
                </div>
              </details>
            </template>
          </div>
        </div>
      </nav>

      <div class="p-space-4 border-t-[0.5px] border-bg-subtle bg-bg-card flex items-center justify-between">
        <div class="flex items-center gap-space-2 min-w-0">
          <div class="w-8 h-8 rounded-full bg-primary-tint text-primary flex items-center justify-center text-xs font-medium uppercase shrink-0">
            {{ userInitials }}
          </div>
          <div class="min-w-0">
            <p class="text-[13px] font-medium text-text-primary truncate leading-tight">
              {{ auth?.user?.name || 'Guest User' }}
            </p>
            <p class="text-[11px] text-text-secondary truncate leading-none mt-1">
              {{ roleName }}
            </p>
          </div>
        </div>
      </div>
    </aside>

    <div class="flex-1 pl-[264px] flex flex-col min-h-screen">
      <header class="h-14 bg-bg-card border-b-[0.5px] border-border flex items-center justify-between px-space-12 sticky top-0 z-10 shrink-0">
        <div class="text-[13px] font-medium text-text-secondary flex items-center gap-1.5">
          <span>School MS</span>
          <span class="text-text-tertiary">/</span>
          <span class="text-text-primary">{{ pageTitle }}</span>
        </div>

        <div class="flex items-center gap-space-4">
          <a
            v-if="appSettings?.frontend_website !== '0'"
            href="/"
            target="_blank"
            class="p-2 hover:bg-bg-subtle text-text-secondary hover:text-primary rounded-sm transition-colors duration-120"
            title="Visit Public Website"
          >
            <Globe class="w-4 h-4" />
          </a>

          <div class="relative group">
            <button class="flex items-center gap-1.5 text-[13px] font-medium text-text-secondary hover:text-text-primary py-2 focus:outline-none">
              <span>{{ auth?.user?.name }}</span>
              <ChevronDown class="w-3.5 h-3.5 transition-transform duration-150 group-hover:rotate-180" />
            </button>
            <div class="absolute right-0 mt-0 w-48 bg-bg-card border-[0.5px] border-border rounded-sm shadow-none py-1.5 hidden group-hover:block hover:block z-30">
              <a href="/profile" class="dropdown-link">
                <User class="w-4 h-4" />
                <span>My Profile</span>
              </a>
              <a href="/change-password" class="dropdown-link">
                <Lock class="w-4 h-4" />
                <span>Change Password</span>
              </a>
              <div class="h-[0.5px] bg-border my-1.5"></div>
              <a href="/logout" class="dropdown-link text-danger-text hover:bg-danger-bg">
                <LogOut class="w-4 h-4" />
                <span>Log out</span>
              </a>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 p-space-12 max-w-[1040px] w-full mx-auto">
        <div v-if="flash?.success || flash?.error || flash?.warning" class="mb-space-6">
          <div
            v-if="flash.success"
            class="bg-success-bg border-[0.5px] border-[#86CFA0] rounded-sm p-4 text-[13px] text-success-text flex items-start gap-2.5 animate-fadeIn"
          >
            <CheckCircle class="w-4 h-4 text-success shrink-0 mt-0.5" />
            <div>
              <p class="font-medium">Success</p>
              <p class="mt-1 opacity-90" v-html="flash.success"></p>
            </div>
          </div>

          <div
            v-if="flash.error"
            class="bg-danger-bg border-[0.5px] border-[#DC4640]/30 rounded-sm p-4 text-[13px] text-danger-text flex items-start gap-2.5 animate-fadeIn"
          >
            <XCircle class="w-4 h-4 text-danger shrink-0 mt-0.5" />
            <div>
              <p class="font-medium">Error</p>
              <p class="mt-1 opacity-90" v-html="flash.error"></p>
            </div>
          </div>

          <div
            v-if="flash.warning"
            class="bg-warning-bg border-[0.5px] border-[#E4B86B] rounded-sm p-4 text-[13px] text-warning-text flex items-start gap-2.5 animate-fadeIn"
          >
            <AlertTriangle class="w-4 h-4 text-warning shrink-0 mt-0.5" />
            <div>
              <p class="font-medium">Warning</p>
              <p class="mt-1 opacity-90" v-html="flash.warning"></p>
            </div>
          </div>
        </div>

        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { cn } from '@/lib/utils';
import {
  AlertTriangle,
  BarChart3,
  BookOpen,
  Building2,
  CalendarCheck,
  CalendarDays,
  Camera,
  CheckCircle,
  ChevronDown,
  ChevronRight,
  Circle,
  ClipboardList,
  ContactRound,
  FileBarChart,
  FileText,
  Globe,
  GraduationCap,
  HelpCircle,
  Home,
  LayoutDashboard,
  LineChart,
  Lock,
  LogOut,
  Medal,
  Megaphone,
  MessageSquare,
  Percent,
  PieChart,
  ScrollText,
  Settings,
  Shield,
  SlidersHorizontal,
  User,
  UserCog,
  UserRoundCog,
  Users,
  XCircle
} from 'lucide-vue-next';

defineProps({
  pageTitle: {
    type: String,
    default: 'Dashboard'
  }
});

const page = usePage();
const auth = computed(() => page.props.auth);
const appSettings = computed(() => page.props.appSettings);
const flash = computed(() => page.props.flash);

const isStudent = computed(() => auth.value?.role_id === 3);
const showWebsite = computed(() => appSettings.value?.frontend_website !== '0');

const adminMenu = computed(() => [
  {
    label: 'Main',
    items: [
      { label: 'Dashboard', href: '/dashboard', icon: LayoutDashboard },
      { label: 'Students', href: '/student', icon: GraduationCap },
      { label: 'Teachers', href: '/teacher', icon: Users },
      { label: 'Users', href: '/user', icon: UserCog },
    ],
  },
  {
    label: 'School',
    items: [
      {
        label: 'Attendance',
        icon: CalendarCheck,
        children: [
          { label: 'Student Attendance', href: '/student-attendance', icon: GraduationCap },
          { label: 'Employee Attendance', href: '/employee-attendance', icon: ContactRound },
        ],
      },
      {
        label: 'Academic',
        icon: BookOpen,
        children: [
          { label: 'Class', href: '/academic/class', icon: Building2 },
          { label: 'Section', href: '/academic/section', icon: ClipboardList },
          { label: 'Subject', href: '/academic/subject', icon: BookOpen },
        ],
      },
      {
        label: 'Exam',
        icon: FileText,
        children: [
          { label: 'Rule', href: '/exam/rule', icon: Settings },
          { label: 'Exam', href: '/exam', icon: FileText },
          { label: 'Grade', href: '/exam/grade', icon: BarChart3 },
        ],
      },
      {
        label: 'Marks & Result',
        icon: Percent,
        children: [
          { label: 'Marks', href: '/marks', icon: Percent },
          { label: 'Result', href: '/result', icon: Medal },
        ],
      },
      { label: 'Promotion', href: '/promotion', icon: Medal },
    ],
  },
  {
    label: 'Operations',
    items: [
      {
        label: 'HRM',
        icon: Users,
        children: [
          { label: 'Employee', href: '/hrm/employee', icon: ContactRound },
          { label: 'Leave', href: '/hrm/leave', icon: CalendarDays },
          { label: 'Policy', href: '/hrm/policy', icon: SlidersHorizontal },
        ],
      },
      {
        label: 'Reports',
        icon: FileBarChart,
        children: [
          {
            label: 'Student',
            icon: GraduationCap,
            children: [
              { label: 'Monthly Attendance', href: '/report/student-monthly-attendance', icon: CalendarCheck },
              { label: 'Student List', href: '/report/student-list', icon: GraduationCap },
            ],
          },
          {
            label: 'HRM',
            icon: Users,
            children: [
              { label: 'Monthly Attendance', href: '/report/employee-monthly-attendance', icon: CalendarCheck },
              { label: 'Employee List', href: '/report/employee-list', icon: ContactRound },
            ],
          },
          {
            label: 'Marks & Result',
            icon: Percent,
            children: [
              { label: 'Marksheet Public', href: '/online-result', icon: FileText },
            ],
          },
          { label: 'Application Log', href: '/logs', icon: ScrollText },
        ],
      },
    ],
  },
  {
    label: 'Website',
    items: showWebsite.value ? [
      {
        label: 'Site',
        icon: Globe,
        children: [
          { label: 'Dashboard', href: '/site/dashboard', icon: LayoutDashboard },
          {
            label: 'Home',
            icon: Home,
            children: [
              { label: 'Sliders', href: '/slider', icon: SlidersHorizontal },
              { label: 'About Us', href: '/site/about-content', icon: FileText },
              { label: 'Our Services', href: '/site/service', icon: FileText },
              { label: 'Statistic', href: '/site/statistic', icon: PieChart },
              { label: 'Testimonials', href: '/site/testimonial', icon: MessageSquare },
              { label: 'Subscribers', href: '/site/subscribe', icon: Users },
            ],
          },
          { label: 'Class', href: '/class_profile', icon: Building2 },
          { label: 'Teachers', href: '/teacher_profile', icon: Users },
          { label: 'Events', href: '/event', icon: Megaphone },
          { label: 'Gallery', href: '/site/gallery', icon: Camera },
          { label: 'Contact Us', href: '/site/contact-us', icon: Globe },
          { label: 'FAQ', href: '/site/fqa', icon: HelpCircle },
          { label: 'Timeline', href: '/site/timeline', icon: CalendarDays },
          { label: 'Settings', href: '/site/settings', icon: Settings },
          { label: 'Analytics', href: '/site/analytics', icon: LineChart },
        ],
      },
    ] : [],
  },
  {
    label: 'Administrator',
    items: [
      {
        label: 'Administrator',
        icon: Shield,
        children: [
          { label: 'Institute Settings', href: '/settings/institute', icon: Building2 },
          { label: 'Academic Year', href: '/administrator/academic_year', icon: CalendarDays },
          { label: 'Report Settings', href: '/settings/report', icon: FileBarChart },
          { label: 'User Role', href: '/role', icon: Users },
          { label: 'System Admin', href: '/administrator/user', icon: UserRoundCog },
          { label: 'Reset User Password', href: '/administrator/user/reset-password', icon: Lock },
        ],
      },
    ],
  },
]);

const studentMenu = [
  {
    label: 'Main',
    items: [
      { label: 'Dashboard', href: '/dashboard', icon: LayoutDashboard },
      { label: 'Academic', href: '/st-profile', icon: BookOpen },
      { label: 'Marksheet Public', href: '/online-result', icon: FileText },
    ],
  },
];

const visibleMenu = computed(() => isStudent.value ? studentMenu : adminMenu.value.filter((section) => section.items.length));

const currentUrl = computed(() => page.url.split('?')[0]);

const isActive = (href) => currentUrl.value === href || currentUrl.value.startsWith(`${href}/`);

const isGroupActive = (item) => item.children?.some((child) => child.children ? isGroupActive(child) : isActive(child.href));

const isGroupOpen = (item) => isGroupActive(item);

const navLinkClass = (item) => cn(
  'flex items-center gap-space-2 px-space-2 py-1.5 rounded-sm text-[13px] transition-all duration-120',
  isActive(item.href)
    ? 'bg-bg-subtle text-primary font-medium'
    : 'text-text-secondary hover:bg-bg-subtle hover:text-text-primary'
);

const navChildClass = (item) => cn(
  'flex items-center gap-space-2 px-space-2 py-1.5 rounded-sm text-[12px] transition-all duration-120',
  isActive(item.href)
    ? 'bg-bg-subtle text-primary font-medium'
    : 'text-text-secondary hover:bg-bg-subtle hover:text-text-primary'
);

const navNestedClass = (item) => cn(
  'flex items-center gap-space-2 px-space-2 py-1.5 rounded-sm text-[12px] transition-all duration-120',
  isActive(item.href)
    ? 'bg-bg-subtle text-primary font-medium'
    : 'text-text-secondary hover:bg-bg-subtle hover:text-text-primary'
);

const userInitials = computed(() => {
  const name = auth.value?.user?.name || '';
  if (!name) return 'U';
  const parts = name.split(' ');
  if (parts.length >= 2) {
    return (parts[0][0] + parts[1][0]).toUpperCase();
  }
  return name.slice(0, 2).toUpperCase();
});

const roleName = computed(() => {
  if (auth.value?.user?.is_super_admin) return 'Super Admin';
  const roleId = auth.value?.role_id;
  if (roleId === 1) return 'Administrator';
  if (roleId === 2) return 'Teacher';
  if (roleId === 3) return 'Student';
  return 'User';
});
</script>

<style scoped>
summary::-webkit-details-marker {
  display: none;
}

.dropdown-link {
  display: flex;
  align-items: center;
  gap: var(--spacing-space-2);
  padding: 8px 16px;
  font-size: 13px;
  color: var(--color-text-secondary);
  transition: background 0.12s, color 0.12s;
}

.dropdown-link:hover {
  background: var(--color-bg-subtle);
  color: var(--color-text-primary);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-4px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
  animation: fadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
