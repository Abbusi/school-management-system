<template>
  <Head title="Students" />

  <BackendLayout pageTitle="Students">
    <div class="mb-space-8 flex flex-col gap-space-4 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-text-secondary">
          Student registry
        </p>
        <h1 class="text-[22px] font-medium leading-tight text-text-primary">Students</h1>
        <p class="mt-1 max-w-[64ch] text-[14px] text-text-secondary">
          Filter by class, section and status, then manage student records from a clean workspace.
        </p>
      </div>

      <a href="/student/create">
        <Button>
          <PlusCircle class="mr-space-2 h-4 w-4" />
          Add New
        </Button>
      </a>
    </div>

    <Card class="mb-space-5">
      <form class="grid gap-space-3 md:grid-cols-[repeat(4,minmax(0,1fr))_auto]" @submit.prevent="applyFilters">
        <div v-if="isCollege">
          <label class="filter-label" for="academic_year">Academic year</label>
          <Select id="academic_year" v-model="filters.academic_year">
            <option value="">Pick a year...</option>
            <option v-for="year in academicYearOptions" :key="year.value" :value="year.value">
              {{ year.label }}
            </option>
          </Select>
        </div>

        <div>
          <label class="filter-label" for="class">Class</label>
          <Select id="class" v-model="filters.class" @update:modelValue="filters.section = ''">
            <option value="">Pick a class...</option>
            <option v-for="classItem in classOptions" :key="classItem.value" :value="classItem.value">
              {{ classItem.label }}
            </option>
          </Select>
        </div>

        <div>
          <label class="filter-label" for="section">Section</label>
          <Select id="section" v-model="filters.section" :disabled="!sectionOptions.length">
            <option value="">Pick a section...</option>
            <option v-for="section in sectionOptions" :key="section.value" :value="section.value">
              {{ section.label }}
            </option>
          </Select>
        </div>

        <div>
          <label class="filter-label" for="status">Status</label>
          <Select id="status" v-model="filters.status">
            <option value="1">Active</option>
            <option value="0">Deactivated</option>
          </Select>
        </div>

        <div class="flex items-end gap-space-2">
          <Button type="submit" class="h-9">
            <Filter class="mr-space-2 h-4 w-4" />
            Filter
          </Button>
          <Button type="button" variant="outline" class="h-9" @click="clearFilters">
            Clear
          </Button>
        </div>
      </form>
    </Card>

    <Card class="p-0">
      <div class="flex items-center justify-between border-b-[0.5px] border-bg-subtle px-space-5 py-space-4">
        <div>
          <h2 class="text-[16px] font-medium text-text-primary">Student list</h2>
          <p class="mt-1 text-[13px] text-text-secondary">{{ localStudents.length }} record{{ localStudents.length === 1 ? '' : 's' }}</p>
        </div>
      </div>

      <Table>
        <TableHeader>
          <TableRow>
            <TableHead class="w-[52px]">#</TableHead>
            <TableHead>Student</TableHead>
            <TableHead>Regi. No.</TableHead>
            <TableHead>Roll</TableHead>
            <TableHead>ID Card</TableHead>
            <TableHead>Contact</TableHead>
            <TableHead>Status</TableHead>
            <TableHead class="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="(student, index) in localStudents" :key="student.id">
            <TableCell class="text-text-secondary">{{ index + 1 }}</TableCell>
            <TableCell>
              <div class="flex min-w-[220px] items-center gap-space-3">
                <img :src="student.photo_url" :alt="student.name" class="h-9 w-9 rounded-sm border-[0.5px] border-border object-cover" />
                <div class="min-w-0">
                  <p class="truncate text-[13px] font-medium text-text-primary">{{ student.name }}</p>
                  <p class="truncate text-[11px] text-text-secondary">{{ student.email || 'No email' }}</p>
                </div>
              </div>
            </TableCell>
            <TableCell class="font-mono text-[12px]">{{ student.regi_no || '-' }}</TableCell>
            <TableCell>{{ student.roll_no || '-' }}</TableCell>
            <TableCell class="font-mono text-[12px]">{{ student.card_no || '-' }}</TableCell>
            <TableCell>
              <div class="text-[12px] text-text-secondary">
                <p>{{ student.phone_no || '-' }}</p>
              </div>
            </TableCell>
            <TableCell>
              <div class="flex items-center gap-space-2">
                <Switch
                  :model-value="student.status"
                  :disabled="statusUpdating === student.id"
                  @update:modelValue="toggleStatus(student, $event)"
                />
                <Badge :variant="student.status ? 'success' : 'danger'">
                  {{ student.status ? 'Active' : 'Deactivated' }}
                </Badge>
              </div>
            </TableCell>
            <TableCell>
              <div class="flex justify-end gap-1.5">
                <a :href="`/student/${student.id}`" class="icon-button" title="Details">
                  <Eye class="h-4 w-4" />
                </a>
                <a v-if="!student.is_promoted" :href="`/student/${student.id}/edit`" class="icon-button" title="Edit">
                  <Pencil class="h-4 w-4" />
                </a>
                <button v-if="!student.is_promoted" class="icon-button text-danger-text hover:bg-danger-bg" title="Delete" @click="destroyStudent(student)">
                  <Trash2 class="h-4 w-4" />
                </button>
              </div>
            </TableCell>
          </TableRow>

          <TableRow v-if="!localStudents.length">
            <TableCell colspan="8" class="py-space-12 text-center text-[13px] text-text-secondary">
              Select a class and filters to display students.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </Card>
  </BackendLayout>
</template>

<script setup>
import { reactive, computed, ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import { Eye, Filter, Pencil, PlusCircle, Trash2 } from 'lucide-vue-next';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import Badge from '@/Components/ui/Badge.vue';
import Button from '@/Components/ui/Button.vue';
import Card from '@/Components/ui/Card.vue';
import Select from '@/Components/ui/Select.vue';
import Switch from '@/Components/ui/Switch.vue';
import Table from '@/Components/ui/Table.vue';
import TableBody from '@/Components/ui/TableBody.vue';
import TableCell from '@/Components/ui/TableCell.vue';
import TableHead from '@/Components/ui/TableHead.vue';
import TableHeader from '@/Components/ui/TableHeader.vue';
import TableRow from '@/Components/ui/TableRow.vue';

const props = defineProps({
  students: { type: Array, default: () => [] },
  classes: { type: Array, default: () => [] },
  sections: { type: Array, default: () => [] },
  academicYears: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
  isCollege: { type: Boolean, default: false },
});

const filters = reactive({
  class: props.filters.class || '',
  section: props.filters.section || '',
  academic_year: props.filters.academic_year || '',
  status: props.filters.status ?? '1',
});

const classOptions = computed(() => props.classes);
const sectionOptions = computed(() => props.sections);
const academicYearOptions = computed(() => props.academicYears);
const statusUpdating = ref(null);
const localStudents = ref([...props.students]);

watch(() => props.students, (students) => {
  localStudents.value = [...students];
});

const applyFilters = () => {
  router.get('/student', {
    class: filters.class || undefined,
    section: filters.section || undefined,
    academic_year: filters.academic_year || undefined,
    status: filters.status,
  }, {
    preserveState: true,
    preserveScroll: true,
  });
};

const clearFilters = () => {
  router.get('/student');
};

const destroyStudent = (student) => {
  if (!window.confirm(`Delete ${student.name}?`)) return;

  router.delete(`/student/${student.id}`, {
    preserveScroll: true,
  });
};

const toggleStatus = (student, checked) => {
  statusUpdating.value = student.id;

  axios.post(`/student/status/${student.id}`, {
    status: checked ? '1' : '0',
  }, {
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
    },
  }).then((response) => {
    if (response.data?.success) {
      student.status = checked;
    } else {
      window.alert(response.data?.message || 'Status could not be updated.');
    }
  }).catch(() => {
    window.alert('Status could not be updated.');
  }).finally(() => {
    statusUpdating.value = null;
  });
};
</script>

<style scoped>
.filter-label {
  display: block;
  margin-bottom: 6px;
  font-size: 12px;
  font-weight: 500;
  color: var(--color-text-secondary);
}

.icon-button {
  display: inline-flex;
  width: 32px;
  height: 32px;
  align-items: center;
  justify-content: center;
  border-radius: var(--radius-sm);
  color: var(--color-text-secondary);
  transition: background 0.12s, color 0.12s;
}

.icon-button:hover {
  background: var(--color-bg-subtle);
  color: var(--color-text-primary);
}
</style>
