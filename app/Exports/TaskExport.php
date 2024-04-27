<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaskExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Task::select(
            'project_id',
            'name',
            'description',
            'start_time',
            'end_time',
            'priority',
            'status', 
            'person_id'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Project',
            'Name',
            'Description',
            'Start Time',
            'End Time',
            'Priority',
            'Status',
            'Person',
        ];
    }
}
