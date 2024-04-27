@props(['elements'])

@foreach ($elements as $e)
    <x-tree-view-table-row :element="$e" />
@endforeach