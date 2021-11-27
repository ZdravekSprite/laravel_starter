@props(['disabled' => false, 'width' => 'full', 'rounded' => '-md'])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block mt-1 w-'.$width.' rounded'.$rounded.' shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
