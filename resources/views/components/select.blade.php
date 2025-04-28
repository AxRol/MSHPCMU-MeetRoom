@props(['name', 'options' => [], 'selected' => null, 'label' => null, 'placeholder' => 'Sélectionner une salle'])

@if ($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
@endif

<select name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm']) }}>
    <option value="">{{ $placeholder }}</option> <!-- Utilisation de la propriété placeholder -->
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>{{ $text }}</option>
    @endforeach
</select>
