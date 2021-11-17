            <!-- Name -->
            <div>
              <x-label for="name" :value="__('Name')" />
              <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ isset($role) ? $role->name : '' }}" required autofocus />
            </div>

            <!-- Description -->
            <div class="mt-4">
              <x-label for="description" :value="__('Description')" />
              <x-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ isset($role) ? $role->description : '' }}" required />
            </div>
