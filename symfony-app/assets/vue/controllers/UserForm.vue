<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
  user: {
    type: Object,
    default: null
  },
  isShowMode: {
    type: Boolean,
    default: false
  },
  indexUserUrl: {
    type: String,
    default: ''
  },
  editUserUrl: {
    type: String,
    default: ''
  },
  showUserUrl: {
    type: String,
    default: ''
  },
  errors: {
    type: [Object, null],
    default: () => ({})
  }
});

const isEditMode = computed(() => !!props.user);

const formData = ref({
  firstName: '',
  lastName: '',
  birthdate: '',
  gender: ''
});

const formErrors = ref({});
const isDisabled = ref(false);

const maxDate = new Date().toISOString().split('T')[0];

onMounted(() => {
  if (props.user) {
    formData.value = {
      firstName: props.user.firstName,
      lastName: props.user.lastName,
      birthdate: props.user.birthdate,
      gender: props.user.gender
    };
  }

  if (props.errors && Object.keys(props.errors).length > 0) {
    formErrors.value = props.errors;
  }

  isDisabled.value = props.isShowMode;
});

const clearError = (field) => {
  delete formErrors.value[field];
};

const submit = () => {
  isDisabled.value = true;

  const form = document.querySelector('form[name="user_input"]');
  if (form) {
    const fields = {
      'user_input[firstName]': formData.value.firstName,
      'user_input[lastName]': formData.value.lastName,
      'user_input[birthdate]': formData.value.birthdate,
      'user_input[gender]': formData.value.gender
    };

    Object.entries(fields).forEach(([name, value]) => {
      const input = form.querySelector(`[name="${ name }"]`);
      if (input) {
        input.value = value;
      }
    });

    form.submit();
  }
};
</script>
<template>
  <div class="container-fluid py-2">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h3 class="mb-0">
          <template v-if="isShowMode">
            User: {{ user.firstName }} {{ user.lastName }}
          </template>
          <template v-else-if="isEditMode">
            Edit user: {{ user.firstName }} {{ user.lastName }}
          </template>
          <template v-else>
            New user
          </template>
        </h3>
        <div class="d-flex gap-1">
          <a :href="indexUserUrl" class="btn btn-light btn-sm">
            < List
          </a>
          <a v-if="editUserUrl" :href="editUserUrl" class="btn btn-warning btn-sm">
            Edit
          </a>
          <a v-if="showUserUrl" :href="showUserUrl" class="btn btn-info btn-sm">
            Show
          </a>
        </div>
      </div>
      <div class="card-body">
        <form @submit.prevent="submit" novalidate>
          <div v-if="user" class="mb-3">
            <label for="id" class="form-label text-dark fw-bold">
              ID <span class="text-danger">*</span>
            </label>
            <input
                id="id"
                :value="user.id"
                type="text"
                disabled
                class="form-control"
            >
          </div>
          <div class="mb-3">
            <label for="firstName" class="form-label text-dark fw-bold">
              First Name <span class="text-danger">*</span>
            </label>
            <input
                id="firstName"
                v-model="formData.firstName"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': formErrors.firstName }"
                :disabled="isDisabled"
                @input="clearError('firstName')"
            >
            <div v-if="formErrors.firstName" class="invalid-feedback">
              {{ formErrors.firstName }}
            </div>
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label text-dark fw-bold">
              Last Name <span class="text-danger">*</span>
            </label>
            <input
                id="lastName"
                v-model="formData.lastName"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': formErrors.lastName }"
                :disabled="isDisabled"
                @input="clearError('lastName')"
            >
            <div v-if="formErrors.lastName" class="invalid-feedback">
              {{ formErrors.lastName }}
            </div>
          </div>
          <div class="mb-3">
            <label for="birthdate" class="form-label text-dark fw-bold">
              Birthdate <span class="text-danger">*</span>
            </label>
            <input
                id="birthdate"
                v-model="formData.birthdate"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': formErrors.birthdate }"
                :max="maxDate"
                :disabled="isDisabled"
                @input="clearError('birthdate')"
            >
            <div v-if="formErrors.birthdate" class="invalid-feedback">
              {{ formErrors.birthdate }}
            </div>
          </div>

          <div class="mb-3">
            <label for="gender" class="form-label text-dark fw-bold">
              Gender <span class="text-danger">*</span>
            </label>
            <select
                id="gender"
                v-model="formData.gender"
                class="form-select"
                :class="{ 'is-invalid': formErrors.gender }"
                :disabled="isDisabled"
                @change="clearError('gender')"
            >
              <option value="male">male</option>
              <option value="female">female</option>
            </select>
            <div v-if="formErrors.gender" class="invalid-feedback">
              {{ formErrors.gender }}
            </div>
          </div>
          <div v-if="!isShowMode" class="d-flex gap-2 justify-content-end">
            <button type="submit" class="btn btn-success" :disabled="isDisabled">
              {{ isEditMode ? 'Update' : 'Create' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
