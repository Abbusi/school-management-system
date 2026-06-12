<template>
  <Head title="Add Student" />

  <BackendLayout pageTitle="Add Student">
    <div class="mb-space-8 flex flex-col gap-space-4 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-text-secondary">
          Student registry
        </p>
        <h1 class="text-[22px] font-medium leading-tight text-text-primary">Add Student</h1>
        <p class="mt-1 max-w-[64ch] text-[14px] text-text-secondary">
          Create a complete student profile, registration, guardian details and access credentials.
        </p>
      </div>
      <a href="/student">
        <Button variant="outline">
          <ArrowLeft class="mr-space-2 h-4 w-4" />
          Back to list
        </Button>
      </a>
    </div>

    <form class="space-y-space-5" @submit.prevent="submit">
      <Card class="border-warning/30 bg-warning-bg/40">
        <div class="flex flex-col gap-space-3 text-warning-text sm:flex-row sm:items-center sm:justify-between">
          <div class="flex gap-space-3">
          <AlertTriangle class="h-4 w-4 shrink-0 mt-0.5" />
          <p class="text-[13px] leading-5">
            Create class, section and subjects before adding a student.
          </p>
          </div>
          <div class="flex flex-wrap gap-space-2">
            <a href="/academic/class/create" class="quick-link">Create class</a>
            <a href="/academic/section/create" class="quick-link">Create section</a>
            <a href="/academic/subject/create" class="quick-link">Create subject</a>
          </div>
        </div>
      </Card>

      <FormSection title="Student Info" description="Identity, personal information and contact details.">
        <Field label="Name" required :error="form.errors.name">
          <Input v-model="form.name" autofocus placeholder="Student name" />
        </Field>
        <Field label="Nick Name" :error="form.errors.nick_name">
          <Input v-model="form.nick_name" placeholder="Name for SMS" />
        </Field>
        <Field label="Date of birth" required :error="form.errors.dob">
          <Input v-model="form.dob" type="date" />
        </Field>
        <Field label="Gender" required :error="form.errors.gender">
          <Select v-model="form.gender">
            <option value="">Select an option</option>
            <option v-for="item in options.genders" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="Religion" :error="form.errors.religion">
          <Select v-model="form.religion">
            <option value="">Select an option</option>
            <option v-for="item in options.religions" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="Blood Group" :error="form.errors.blood_group">
          <Select v-model="form.blood_group">
            <option value="">Select an option</option>
            <option v-for="item in options.bloodGroups" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="Nationality" required :error="form.errors.nationality">
          <Select v-model="form.nationality">
            <option value="Bangladeshi">Bangladeshi</option>
            <option value="Other">Other</option>
          </Select>
        </Field>
        <Field label="Other nationality" :error="form.errors.nationality_other">
          <Input v-model="form.nationality_other" :disabled="form.nationality !== 'Other'" placeholder="Nationality" />
        </Field>
        <Field label="Email" :error="form.errors.email">
          <Input v-model="form.email" type="email" placeholder="email address" />
        </Field>
        <Field label="Phone/Mobile No." :error="form.errors.phone_no">
          <Input v-model="form.phone_no" placeholder="phone or mobile number" />
        </Field>
        <Field label="Photo" :error="form.errors.photo" class="md:col-span-2">
          <input
            type="file"
            accept=".jpeg,.jpg,.png"
            class="block h-9 w-full rounded-sm border-[0.5px] border-border bg-bg-card px-3 py-1.5 text-[13px] text-text-secondary file:mr-space-3 file:border-0 file:bg-bg-subtle file:px-space-2 file:py-1 file:text-[12px] file:font-medium file:text-text-primary"
            @change="form.photo = $event.target.files[0]"
          />
          <p class="mt-1 text-[11px] text-text-tertiary">Min 150 x 150, max 200 KB.</p>
        </Field>
        <Field label="Extra Curricular Activity" :error="form.errors.extra_activity" class="md:col-span-2">
          <Textarea v-model="form.extra_activity" rows="3" />
        </Field>
        <Field label="Note" :error="form.errors.note" class="md:col-span-2">
          <Textarea v-model="form.note" rows="3" />
        </Field>
      </FormSection>

      <FormSection title="Guardian Info" description="Parent, guardian and address information.">
        <Field label="Father Name" :error="form.errors.father_name">
          <Input v-model="form.father_name" />
        </Field>
        <Field label="Father Phone/Mobile No." :error="form.errors.father_phone_no">
          <Input v-model="form.father_phone_no" />
        </Field>
        <Field label="Mother Name" :error="form.errors.mother_name">
          <Input v-model="form.mother_name" />
        </Field>
        <Field label="Mother Phone/Mobile No." :error="form.errors.mother_phone_no">
          <Input v-model="form.mother_phone_no" />
        </Field>
        <Field label="Local Guardian" :error="form.errors.guardian">
          <Input v-model="form.guardian" />
        </Field>
        <Field label="Guardian Phone/Mobile No." :error="form.errors.guardian_phone_no">
          <Input v-model="form.guardian_phone_no" />
        </Field>
        <Field label="Present Address" :error="form.errors.present_address" class="md:col-span-2">
          <Textarea v-model="form.present_address" rows="3" />
        </Field>
        <Field label="Permanent Address" required :error="form.errors.permanent_address" class="md:col-span-2">
          <Textarea v-model="form.permanent_address" rows="3" />
        </Field>
      </FormSection>

      <FormSection title="Academic Info" description="Registration, class assignment and SMS routing.">
        <Field v-if="isCollege" label="Academic Year" required :error="form.errors.academic_year">
          <Select v-model="form.academic_year">
            <option value="">Pick a year...</option>
            <option v-for="item in options.academicYears" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="Class Name" required :error="form.errors.class_id">
          <Select v-model="form.class_id" @update:modelValue="loadClassData">
            <option value="">Pick a class...</option>
            <option v-for="item in options.classes" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="Section" required :error="form.errors.section_id">
          <Select v-model="form.section_id" :disabled="!sections.length" @update:modelValue="checkCapacity">
            <option value="">Pick a section...</option>
            <option v-for="item in sections" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="Shift" :error="form.errors.shift">
          <Select v-model="form.shift">
            <option value="">Pick a shift...</option>
            <option v-for="item in options.shifts" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="ID Card No." :error="form.errors.card_no">
          <Input v-model="form.card_no" />
        </Field>
        <Field label="Roll No." :error="form.errors.roll_no">
          <Input v-model="form.roll_no" type="number" />
        </Field>
        <Field label="Board Registration No." :error="form.errors.board_regi_no">
          <Input v-model="form.board_regi_no" />
        </Field>
        <Field label="Notification SMS No." required :error="form.errors.sms_receive_no">
          <Select v-model="form.sms_receive_no">
            <option value="">Select number</option>
            <option v-for="item in options.smsNumbers" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
        <Field label="Siblings" :error="form.errors.siblings">
          <Input v-model="form.siblings" placeholder="1901004,1909201" />
        </Field>
        <Field v-if="options.houses.length" label="House Name" :error="form.errors.house">
          <Select v-model="form.house">
            <option v-for="item in options.houses" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
      </FormSection>

      <FormSection title="Subject Info" description="Subjects are loaded from the selected class.">
        <Field label="Core Subjects" required :error="form.errors.core_subjects" class="md:col-span-2">
          <div class="rounded-sm border-[0.5px] border-border bg-bg-subtle p-space-3">
            <div v-if="coreSubjects.length" class="flex flex-wrap gap-space-2">
              <Badge v-for="subject in coreSubjects" :key="subject.value" variant="neutral">
                {{ subject.label }}
              </Badge>
            </div>
            <p v-else class="text-[13px] text-text-secondary">Select a class to load core subjects.</p>
          </div>
        </Field>
        <Field v-if="subjectSettings.have_selective_subject" label="Selective Subjects" :error="form.errors.selective_subjects">
          <select v-model="form.selective_subjects" multiple class="multi-select">
            <option v-for="item in selectiveSubjects" :key="item.value" :value="item.value">{{ item.label }}</option>
          </select>
          <p v-if="subjectSettings.max_selective_subject" class="mt-1 text-[11px] text-text-tertiary">
            Maximum {{ subjectSettings.max_selective_subject }} subject(s).
          </p>
        </Field>
        <Field v-if="subjectSettings.have_elective_subject" label="4th/Elective Subject" :error="form.errors.fourth_subject">
          <Select v-model="form.fourth_subject">
            <option value="">Select a subject</option>
            <option v-for="item in electiveSubjects" :key="item.value" :value="item.value">{{ item.label }}</option>
          </Select>
        </Field>
      </FormSection>

      <FormSection title="Access Info" description="Leave these blank when the student does not need portal access.">
        <Field label="Username" :error="form.errors.username">
          <Input v-model="form.username" placeholder="leave blank if not needed" />
        </Field>
        <Field label="Password" :error="form.errors.password">
          <Input v-model="form.password" type="password" placeholder="leave blank if not needed" />
        </Field>
      </FormSection>

      <div class="sticky bottom-0 z-10 -mx-space-12 border-t-[0.5px] border-border bg-bg-page/95 px-space-12 py-space-4 backdrop-blur">
        <div class="mx-auto flex max-w-[1040px] items-center justify-between">
          <a href="/student">
            <Button type="button" variant="outline">Cancel</Button>
          </a>
          <Button type="submit" :disabled="form.processing">
            <LoaderCircle v-if="form.processing" class="mr-space-2 h-4 w-4 animate-spin" />
            <PlusCircle v-else class="mr-space-2 h-4 w-4" />
            Add Student
          </Button>
        </div>
      </div>
    </form>
  </BackendLayout>
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { AlertTriangle, ArrowLeft, LoaderCircle, PlusCircle } from 'lucide-vue-next';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import Badge from '@/Components/ui/Badge.vue';
import Button from '@/Components/ui/Button.vue';
import Card from '@/Components/ui/Card.vue';
import Input from '@/Components/ui/Input.vue';
import Select from '@/Components/ui/Select.vue';
import Textarea from '@/Components/ui/Textarea.vue';

const props = defineProps({
  options: { type: Object, required: true },
  defaults: { type: Object, default: () => ({}) },
  isCollege: { type: Boolean, default: false },
});

const options = props.options;
const sections = ref(options.sections || []);
const coreSubjects = ref([]);
const selectiveSubjects = ref([]);
const electiveSubjects = ref([]);
const subjectSettings = reactive({
  have_selective_subject: true,
  have_elective_subject: true,
  max_selective_subject: null,
});

const form = useForm({
  name: '',
  nick_name: '',
  dob: '',
  gender: props.defaults.gender || '',
  religion: props.defaults.religion || '',
  blood_group: props.defaults.blood_group || '',
  nationality: props.defaults.nationality || 'Bangladeshi',
  nationality_other: '',
  photo: null,
  email: '',
  phone_no: '',
  extra_activity: '',
  note: '',
  father_name: '',
  father_phone_no: '',
  mother_name: '',
  mother_phone_no: '',
  guardian: '',
  guardian_phone_no: '',
  present_address: '',
  permanent_address: '',
  academic_year: props.defaults.academic_year || '',
  class_id: props.defaults.class_id || '',
  section_id: props.defaults.section_id || '',
  shift: props.defaults.shift || 'Day',
  card_no: '',
  roll_no: '',
  board_regi_no: '',
  sms_receive_no: '',
  siblings: '',
  house: '',
  core_subjects: [],
  selective_subjects: [],
  fourth_subject: '',
  username: '',
  password: '',
});

watch(() => form.selective_subjects, (subjects) => {
  if (subjectSettings.max_selective_subject && subjects.length > subjectSettings.max_selective_subject) {
    form.selective_subjects = subjects.slice(0, subjectSettings.max_selective_subject);
  }
  if (subjects.includes(form.fourth_subject)) {
    form.fourth_subject = '';
  }
});

watch(() => form.fourth_subject, (subject) => {
  if (subject && form.selective_subjects.includes(subject)) {
    form.fourth_subject = '';
  }
});

const toOptions = (items) => items.map((item) => ({
  value: String(item.id ?? item.value),
  label: item.text ?? item.label,
}));

const loadClassData = async () => {
  form.section_id = '';
  form.core_subjects = [];
  form.selective_subjects = [];
  form.fourth_subject = '';
  sections.value = [];
  coreSubjects.value = [];
  selectiveSubjects.value = [];
  electiveSubjects.value = [];

  if (!form.class_id) return;

  const [sectionResponse, settingsResponse, coreResponse, selectiveResponse, electiveResponse] = await Promise.all([
    axios.get('/public/get-section', { params: { class: form.class_id } }),
    axios.get(`/public/get-subject-settings/${form.class_id}`),
    axios.get('/academic/subject', { params: { class: form.class_id, type: 1 } }),
    axios.get('/academic/subject', { params: { class: form.class_id, type: props.isCollege ? [2, 3] : 3 } }),
    axios.get('/academic/subject', { params: { class: form.class_id, type: props.isCollege ? [2, 3] : 2 } }),
  ]);

  sections.value = toOptions(sectionResponse.data || []);
  Object.assign(subjectSettings, {
    have_selective_subject: Boolean(settingsResponse.data?.have_selective_subject),
    have_elective_subject: Boolean(settingsResponse.data?.have_elective_subject),
    max_selective_subject: settingsResponse.data?.max_selective_subject || null,
  });
  coreSubjects.value = toOptions(coreResponse.data || []);
  selectiveSubjects.value = toOptions(selectiveResponse.data || []);
  electiveSubjects.value = toOptions(electiveResponse.data || []);
  form.core_subjects = coreSubjects.value.map((subject) => subject.value);
};

const checkCapacity = async () => {
  if (!form.class_id || !form.section_id) return;

  const response = await axios.get('/public/check-section-empty-seat', {
    params: {
      class_id: form.class_id,
      section_id: form.section_id,
      academic_year: form.academic_year,
    },
  });

  if (!response.data?.success) {
    window.alert(response.data?.message || 'This section is not available.');
    if (response.data?.clear) {
      form.section_id = '';
    }
  }
};

const submit = () => {
  form.post('/student', {
    forceFormData: true,
    preserveScroll: true,
  });
};
</script>

<script>
export default {
  components: {
    FormSection: {
      props: {
        title: { type: String, required: true },
        description: { type: String, default: '' },
      },
      template: `
        <section class="rounded-md border-[0.5px] border-border bg-bg-card p-space-5">
          <div class="mb-space-5 border-b-[0.5px] border-bg-subtle pb-space-4">
            <h2 class="text-[16px] font-medium text-text-primary">{{ title }}</h2>
            <p v-if="description" class="mt-1 text-[13px] text-text-secondary">{{ description }}</p>
          </div>
          <div class="grid gap-space-4 md:grid-cols-2 lg:grid-cols-4">
            <slot />
          </div>
        </section>
      `,
    },
    Field: {
      props: {
        label: { type: String, required: true },
        required: { type: Boolean, default: false },
        error: { type: String, default: '' },
      },
      template: `
        <div>
          <label class="mb-1.5 block text-[13px] font-medium text-text-primary">
            {{ label }} <span v-if="required" class="text-danger">*</span>
          </label>
          <slot />
          <p v-if="error" class="mt-1.5 text-[12px] text-danger-text">{{ error }}</p>
        </div>
      `,
    },
  },
};
</script>

<style scoped>
.multi-select {
  min-height: 108px;
  width: 100%;
  border-radius: var(--radius-sm);
  border: 0.5px solid var(--color-border);
  background: var(--color-bg-card);
  padding: 8px;
  font-size: 13px;
  color: var(--color-text-primary);
}

.multi-select:focus {
  outline: none;
  border-color: var(--color-primary);
}

.quick-link {
  display: inline-flex;
  align-items: center;
  height: 28px;
  border-radius: var(--radius-sm);
  border: 0.5px solid color-mix(in srgb, var(--color-warning) 35%, transparent);
  background: var(--color-bg-card);
  padding: 0 10px;
  font-size: 12px;
  font-weight: 500;
  color: var(--color-warning-text);
  transition: border-color 0.12s, background 0.12s;
}

.quick-link:hover {
  border-color: var(--color-warning);
  background: var(--color-warning-bg);
}
</style>
