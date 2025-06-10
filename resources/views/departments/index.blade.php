<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Departments Management') }}
        </h2>
    </x-slot>

    
    <div 
        class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" 
        x-data="{ selected: null, isSubmitting: false }"
    >
        <!-- Add Department Button -->
        <div class="flex justify-end mb-6">
            <x-primary-button @click.prevent="$dispatch('open-modal', 'add-department')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('Add Department') }}
            </x-primary-button>
        </div>

        <!-- Departments Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                            <th scope="col" class="relative px-6 py-4">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray">
                        @forelse ($departments as $department)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $department->name }}</td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-600 max-w-md">{{ $department->description ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-4">
                                        <button @click="selected = {{ Illuminate\Support\Js::from($department) }}; $dispatch('open-modal', 'edit-department')" class="text-indigo-600 hover:text-indigo-900" title="{{ __('Edit') }}" aria-label="{{ __('Edit Department') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button @click="selected = {{ Illuminate\Support\Js::from($department) }}; $dispatch('open-modal', 'confirm-department-deletion')" class="text-red-600 hover:text-red-900" title="{{ __('Delete') }}" aria-label="{{ __('Delete Department') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500">
                                    {{ __('No departments found. Please add one to get started.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Department Modal -->
        <x-modal name="add-department" :show="$errors->isNotEmpty() && old('from_form') === 'add'" focusable>
            <form method="POST" action="{{ route('departments.store') }}" class="p-6" x-on:submit="isSubmitting = true">
                @csrf
                <input type="hidden" name="from_form" value="add">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Create New Department') }}</h2>
                <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="{{ __('Optional details about the department') }}">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click.prevent="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                    <x-primary-button x-bind:disabled="isSubmitting">{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- Edit Department Modal -->
        <x-modal name="edit-department" :show="$errors->isNotEmpty() && old('from_form') === 'edit'" focusable>
            <form method="POST" x-bind:action="selected ? `/departments/${selected.id}` : ''" class="p-6" x-on:submit="isSubmitting = true">
                @csrf
                @method('PUT')
                <input type="hidden" name="from_form" value="edit">
                <h2 class="text-lg font-medium text-gray-900">{{ __('Edit Department') }}</h2>
                <p class="mt-1 text-sm text-gray-600" x-text="`You are editing the '${selected ? selected.name : ''}' department.`"></p>
                <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="edit-name" :value="__('Name')" />
                        <x-text-input id="edit-name" name="name" type="text" class="mt-1 block w-full" x-model="selected.name" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <x-input-label for="edit-description" :value="__('Description')" />
                        <textarea id="edit-description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="selected.description"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button @click.prevent="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                    <x-primary-button x-bind:disabled="isSubmitting">{{ __('Update') }}</x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- Delete Confirmation Modal -->
        <x-modal name="confirm-department-deletion" focusable>
            <form method="POST" x-bind:action="selected ? `/departments/${selected.id}` : ''" class="p-6 text-center" x-on:submit="isSubmitting = true">
                @csrf
                @method('DELETE')
               
                <h2 class="mt-4 text-lg font-medium text-gray-900">{{ __('Are you sure?') }}</h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('You are about to permanently delete the department') }} <strong x-text="selected ? selected.name : ''"></strong>. {{ __('This action cannot be undone.') }}
                </p>
                <div class="mt-6 flex justify-center space-x-3">
                    <x-secondary-button @click.prevent="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                    <x-danger-button type="submit" x-bind:disabled="isSubmitting">{{ __('Delete Department') }}</x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>