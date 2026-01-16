<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
  users: {
    type: Array,
    required: true
  },
  filters: {
    type: [Object, null],
    default: () => ({})
  },
  newUserUrl: {
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
  deleteUserUrl: {
    type: String,
    default: ''
  },
});

const filters = ref({
  firstName: '',
  lastName: '',
  gender: '',
  birthdateFrom: '',
  birthdateTo: '',
  sort: '',
  sortDirection: 'asc'
});

onMounted(() => {
  if (props.filters) {
    filters.value = {
      firstName: props.filters.firstName || '',
      lastName: props.filters.lastName || '',
      gender: props.filters.gender || '',
      birthdateFrom: props.filters.birthdateFrom || '',
      birthdateTo: props.filters.birthdateTo || '',
      sort: props.filters.sort || '',
      sortDirection: props.filters.sortDirection || ''
    };
  }
});

const hasActiveFilters = computed(() => {
  return filters.value.firstName ||
      filters.value.lastName ||
      filters.value.gender ||
      filters.value.birthdateFrom ||
      filters.value.birthdateTo;
});

const buildUrl = () => {
  const params = new URLSearchParams();

  if (filters.value.firstName) params.append('user_filter[firstName]', filters.value.firstName);
  if (filters.value.lastName) params.append('user_filter[lastName]', filters.value.lastName);
  if (filters.value.gender) params.append('user_filter[gender]', filters.value.gender);
  if (filters.value.birthdateFrom) params.append('user_filter[birthdateFrom]', filters.value.birthdateFrom);
  if (filters.value.birthdateTo) params.append('user_filter[birthdateTo]', filters.value.birthdateTo);

  if (filters.value.sort) {
    params.append('user_filter[sort]', filters.value.sort);
    params.append('user_filter[sortDirection]', filters.value.sortDirection);
  }

  return params.toString() ? `/?${ params.toString() }` : '/';
};

const submitFilters = () => {
  window.location.href = buildUrl();
};

const clearFilters = () => {
  filters.value.firstName = '';
  filters.value.lastName = '';
  filters.value.gender = '';
  filters.value.birthdateFrom = '';
  filters.value.birthdateTo = '';
  submitFilters();
};

const sortBy = (column) => {
  if (filters.value.sort === column) {
    filters.value.sortDirection = filters.value.sortDirection === 'asc' ? 'desc' : 'asc';
  } else {
    filters.value.sort = column;
    filters.value.sortDirection = 'asc';
  }
  submitFilters()
};

const deleteUser = (user) => {
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = props.deleteUserUrl.replace('__ID__', user.id);

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
  if (csrfToken) {
    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_token';
    tokenInput.value = csrfToken;
    form.appendChild(tokenInput);
  }

  document.body.appendChild(form);
  form.submit();
};
</script>
<template>
  <div class="container-fluid py-2">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h3 class="mb-0">
          Users
        </h3>
        <a :href="newUserUrl" class="btn btn-primary btn-sm">
          + New user
        </a>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitFilters" class="mb-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label">First name</label>
              <input
                  v-model="filters.firstName"
                  type="text"
                  class="form-control form-control-sm"
              >
            </div>
            <div class="col-md-3">
              <label class="form-label">Last name</label>
              <input
                  v-model="filters.lastName"
                  type="text"
                  class="form-control form-control-sm"
              >
            </div>
            <div class="col-md-2">
              <label class="form-label">Gender</label>
              <select v-model="filters.gender" class="form-select form-select-sm">
                <option value=""></option>
                <option value="male">male</option>
                <option value="female">female</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Birthdate from</label>
              <input
                  v-model="filters.birthdateFrom"
                  type="date"
                  class="form-control form-control-sm"
              >
            </div>
            <div class="col-md-2">
              <label class="form-label">Birthdate to</label>
              <input
                  v-model="filters.birthdateTo"
                  type="date"
                  class="form-control form-control-sm"
              >
            </div>
          </div>
          <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary btn-sm">
              Apply filters
            </button>
            <button
                v-if="hasActiveFilters"
                type="button"
                @click="clearFilters"
                class="btn btn-outline-secondary btn-sm"
            >
              Clear filters
            </button>
          </div>
        </form>
        <div class="table-responsive">
          <table class="table table-hover table-striped align-middle">
            <thead class="table-light">
            <tr>
              <th>
                <button
                    @click="sortBy('id')"
                    class="btn btn-link text-decoration-none p-0 text-dark fw-bold"
                >
                  ID
                  <template v-if="filters.sort === 'id'">
                    <span v-if="filters.sortDirection === 'asc'">⌃</span>
                    <span v-else>⌄</span>
                  </template>
                </button>
              </th>
              <th>
                <button
                    @click="sortBy('first_name')"
                    class="btn btn-link text-decoration-none p-0 text-dark fw-bold"
                >
                  First name
                  <template v-if="filters.sort === 'first_name'">
                    <span v-if="filters.sortDirection === 'asc'">⌃</span>
                    <span v-else>⌄</span>
                  </template>
                </button>
              </th>
              <th>
                <button
                    @click="sortBy('last_name')"
                    class="btn btn-link text-decoration-none p-0 text-dark fw-bold"
                >
                  Last name
                  <template v-if="filters.sort === 'last_name'">
                    <span v-if="filters.sortDirection === 'asc'">⌃</span>
                    <span v-else>⌄</span>
                  </template>
                </button>
              </th>
              <th>
                <button
                    @click="sortBy('birthdate')"
                    class="btn btn-link text-decoration-none p-0 text-dark fw-bold"
                >
                  Birthdate
                  <template v-if="filters.sort === 'birthdate'">
                    <span v-if="filters.sortDirection === 'asc'">⌃</span>
                    <span v-else>⌄</span>
                  </template>
                </button>
              </th>
              <th>
                <button
                    @click="sortBy('gender')"
                    class="btn btn-link text-decoration-none p-0 text-dark fw-bold"
                >
                  Gender
                  <template v-if="filters.sort === 'gender'">
                    <span v-if="filters.sortDirection === 'asc'">⌃</span>
                    <span v-else>⌄</span>
                  </template>
                </button>
              </th>
              <th style="width: 300px">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="users.length === 0">
              <td colspan="7" class="text-center text-muted py-4">
                No users found. Run import before using this page or adjust filters
              </td>
            </tr>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.firstName }}</td>
              <td>{{ user.lastName }}</td>
              <td>{{ user.birthdate }}</td>
              <td>{{ user.gender }}</td>
              <td class="d-flex gap-1">
                <a
                    :href="showUserUrl.replace('__ID__', user.id)"
                    class="btn btn-sm btn-info"
                >
                  Show
                </a>
                <a
                    :href="editUserUrl.replace('__ID__', user.id)"
                    class="btn btn-sm btn-warning"
                >
                  Edit
                </a>
                <button
                    @click="deleteUser(user)"
                    class="btn btn-sm btn-danger"
                >
                  Delete
                </button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
