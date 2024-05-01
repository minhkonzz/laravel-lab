@props(['elements', 'depth'])

@foreach ($elements as $e)
    <x-tree-view-table-row :element="$e" depth="{{ $depth }}" />
@endforeach