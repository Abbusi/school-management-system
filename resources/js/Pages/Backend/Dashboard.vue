<template>
  <BackendLayout pageTitle="Dashboard">
    <!-- Header Block -->
    <div class="mb-space-8 select-none">
      <p class="text-[11px] font-medium text-text-secondary uppercase tracking-[0.08em] mb-1">Overview</p>
      <h1 class="text-[22px] font-medium text-text-primary leading-tight">School Dashboard</h1>
      <p class="text-text-secondary text-[14px] mt-1 max-w-[64ch]">
        Welcome back! Here is a summary of today's attendance and school statistics.
      </p>
    </div>

    <!-- Admin Stats Grid -->
    <div v-if="isAdmin" class="grid grid-cols-1 md:grid-cols-4 gap-space-4 mb-space-8">
      <Card variant="stat">
        <div class="flex justify-between items-start">
          <div>
            <span class="stat-label">Students</span>
            <div class="stat-value">{{ students }}</div>
          </div>
          <div class="w-8 h-8 rounded-sm bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <GraduationCap class="w-4 h-4" />
          </div>
        </div>
        <div class="mt-space-4">
          <a href="/student" class="text-[11px] font-medium text-primary hover:text-primary-strong flex items-center gap-1 select-none">
            <span>Manage Students</span>
            <ArrowRight class="w-3 h-3" />
          </a>
        </div>
      </Card>

      <Card variant="stat">
        <div class="flex justify-between items-start">
          <div>
            <span class="stat-label">Teachers</span>
            <div class="stat-value">{{ teachers }}</div>
          </div>
          <div class="w-8 h-8 rounded-sm bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <Users class="w-4 h-4" />
          </div>
        </div>
        <div class="mt-space-4">
          <a href="/teacher" class="text-[11px] font-medium text-primary hover:text-primary-strong flex items-center gap-1 select-none">
            <span>Manage Teachers</span>
            <ArrowRight class="w-3 h-3" />
          </a>
        </div>
      </Card>

      <Card variant="stat">
        <div class="flex justify-between items-start">
          <div>
            <span class="stat-label">Employees</span>
            <div class="stat-value">{{ employee }}</div>
          </div>
          <div class="w-8 h-8 rounded-sm bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <UserCheck class="w-4 h-4" />
          </div>
        </div>
        <div class="mt-space-4">
          <a href="/hrm/employee" class="text-[11px] font-medium text-primary hover:text-primary-strong flex items-center gap-1 select-none">
            <span>Manage Employees</span>
            <ArrowRight class="w-3 h-3" />
          </a>
        </div>
      </Card>

      <Card variant="stat">
        <div class="flex justify-between items-start">
          <div>
            <span class="stat-label">Subjects</span>
            <div class="stat-value">{{ subjects }}</div>
          </div>
          <div class="w-8 h-8 rounded-sm bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <BookOpen class="w-4 h-4" />
          </div>
        </div>
        <div class="mt-space-4">
          <a href="/academic/subject" class="text-[11px] font-medium text-primary hover:text-primary-strong flex items-center gap-1 select-none">
            <span>Manage Subjects</span>
            <ArrowRight class="w-3 h-3" />
          </a>
        </div>
      </Card>
    </div>

    <!-- Attendance Chart (For Admins and Teachers) -->
    <div v-if="showAttendance" class="space-y-space-4">
      <Card>
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 mb-space-5 pb-space-3 border-b-[0.5px] border-bg-subtle select-none">
          <div>
            <h3 class="text-base font-medium text-text-primary">Students Today's Attendance</h3>
            <p class="text-[13px] text-text-secondary mt-0.5">Comparative overview of present vs absent students per class.</p>
          </div>
          <!-- Legend -->
          <div class="flex items-center gap-space-4 text-[11px] font-medium uppercase tracking-[0.06em]">
            <div class="flex items-center gap-1.5 text-text-primary">
              <span class="w-2.5 h-2.5 bg-primary rounded-full"></span>
              <span>Present</span>
            </div>
            <div class="flex items-center gap-1.5 text-text-primary">
              <span class="w-2.5 h-2.5 bg-danger rounded-full"></span>
              <span>Absent</span>
            </div>
          </div>
        </div>

        <!-- Bar chart representation -->
        <div class="w-full">
          <div v-if="classesList.length > 0" class="space-y-3">
            <div v-for="(cls, idx) in classesList" :key="idx" class="flex items-center gap-4">
              <span class="w-20 text-[13px] font-medium text-text-primary text-right truncate" :title="cls">{{ cls }}</span>
              <div class="flex-1 flex gap-[1px] items-center h-4 bg-bg-subtle rounded-sm overflow-hidden border-[0.5px] border-border">
                <div
                  v-if="presentValues[idx] > 0"
                  class="bg-primary h-full transition-all duration-300"
                  :style="{ width: getPercentage(presentValues[idx], presentValues[idx] + absentValues[idx]) + '%' }"
                  :title="'Present: ' + presentValues[idx]"
                ></div>
                <div
                  v-if="absentValues[idx] > 0"
                  class="bg-danger h-full transition-all duration-300"
                  :style="{ width: getPercentage(absentValues[idx], presentValues[idx] + absentValues[idx]) + '%' }"
                  :title="'Absent: ' + absentValues[idx]"
                ></div>
              </div>
              <!-- Stat values -->
              <div class="w-24 text-[11px] font-mono text-text-secondary flex gap-2 select-none">
                <span class="text-success-text font-medium">{{ presentValues[idx] }} Pres.</span>
                <span class="text-danger-text font-medium">{{ absentValues[idx] }} Abs.</span>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-space-12 text-text-secondary text-[13px] select-none">
            No attendance data recorded for today.
          </div>
        </div>
      </Card>
    </div>

    <!-- Student Welcome Box -->
    <div v-if="isStudent" class="max-w-md mx-auto py-space-12 text-center select-none animate-fadeIn">
      <div class="bg-success-bg border-[0.5px] border-[#86CFA0] rounded-sm p-space-6">
        <h3 class="text-[18px] font-medium text-success-text">Welcome to CloudSchool</h3>
        <p class="text-[13px] text-success-text opacity-90 mt-space-2 leading-relaxed">
          Your portal is active. Lots of exciting new student features are coming soon.
        </p>
      </div>
    </div>
  </BackendLayout>
</template>

<script setup>
import { computed } from 'vue';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import Card from '@/Components/ui/Card.vue';
import {
  GraduationCap,
  Users,
  UserCheck,
  BookOpen,
  ArrowRight
} from 'lucide-vue-next';

const props = defineProps({
  teachers: { type: Number, default: 0 },
  employee: { type: Number, default: 0 },
  students: { type: Number, default: 0 },
  subjects: { type: Number, default: 0 },
  userRoleId: { type: Number, default: 0 },
  attendanceChartPresentData: { type: Object, default: () => ({}) },
  attendanceChartAbsentData: { type: Object, default: () => ({}) }
});

// Roles mapping (1 = Admin, 2 = Teacher, 3 = Student)
const isAdmin = computed(() => props.userRoleId === 1);
const isStudent = computed(() => props.userRoleId === 3);
const showAttendance = computed(() => props.userRoleId !== 3);

// Transform objects to arrays for loop
const classesList = computed(() => Object.keys(props.attendanceChartPresentData));
const presentValues = computed(() => Object.values(props.attendanceChartPresentData));
const absentValues = computed(() => Object.values(props.attendanceChartAbsentData));

const getPercentage = (value, total) => {
  if (total === 0) return 0;
  return Math.round((value / total) * 100);
};
</script>

<style scoped>
.stat-label {
  font-size: 11px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--color-text-secondary);
}
.stat-value {
  font-size: 22px;
  font-weight: 500;
  margin-top: 6px;
  line-height: 1.1;
  color: var(--color-text-primary);
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(4px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
