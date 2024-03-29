<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit role') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          {{ __('Edit role') }}

          <form method="POST" action="{{ route('role.update', $role) }}">
            @csrf
            @method('PUT')

            @include('admin.roles.form')

            <div class="flex items-center justify-end mt-4">
              <x-button class="ml-3">
                {{ __('Update') }}
              </x-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
