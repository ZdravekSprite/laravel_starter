<template>
  <table class="table-auto w-full">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in items" :key="item.id">
        <th class="flex items-center pr-10">{{ item.name }}</th>
        <td>{{ item.email }}</td>
        <td>{{ item.roles }}</td>
        <td></td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
        props: {
            items: {
                type: Array,
                default: [],
            }
        },
    };
</script>