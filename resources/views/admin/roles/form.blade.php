            <!-- Name -->
            <div>
              <x-label for="name" :value="__('Name')" />
              <x-input id="name" type="text" name="name" value="{{ isset($role) ? $role->name : '' }}" required autofocus />
            </div>

            <!-- Description -->
            <div class="mt-4">
              <x-label for="description" :value="__('Description')" />
              <x-input id="description" type="text" name="description" value="{{ isset($role) ? $role->description : '' }}" required />
            </div>
