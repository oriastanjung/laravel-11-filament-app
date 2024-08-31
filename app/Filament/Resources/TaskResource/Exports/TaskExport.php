<?php


use App\Models\Task;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TaskExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Return the collection of all tasks to be exported.
     */
    public function collection()
    {   

        return Task::where('isFinish',true)->select('id', 'title', 'code', 'client_name', 'client_phone', 'price', 'modal', 'isFinish', 'created_at', 'karyawan_id')
            ->get();
    }

    /**
     * Set the headings for the exported file.
     */
    public function headings(): array
    {
        return [
            'No',
            'Title',
            'Service Code',
            'Client Name',
            'Client Phone',
            'Service Price',
            'Modal Price',
            'Karyawan Name',
            'Status',
            'Created At',
            'Benefit', // Kolom benefit yang akan ditambahkan
        ];
    }

    /**
     * Map the data for each row.
     *
     * @param \App\Models\Task $task
     * @return array
     */

    protected $index = 0;
    public function map($task): array
    {
        return [
            ++$this->index,
            $task->title,
            $task->code,
            $task->client_name,
            $task->client_phone,
            'Rp ' . number_format($task->price, 0, ',', '.') . ',-',
            'Rp ' . number_format($task->modal, 0, ',', '.') . ',-',
            $task->karyawan_id ? User::find($task->karyawan_id)->name : 'N/A', // Nama karyawan
            $task->isFinish ? 'Selesai' : 'Belum Selesai',
            $task->created_at->format('d F Y'),
            $this->calculateBenefit($task) // Menambahkan kolom benefit
        ];
    }

    /**
     * Calculate the benefit for a given task.
     *
     * @param \App\Models\Task $task
     * @return string
     */
    protected function calculateBenefit($task)
    {
        // Hitung benefit berdasarkan harga dan modal
        $benefit = $task->price - $task->modal;
        return 'Rp ' . number_format($benefit, 0, ',', '.') . ',-';
    }
}
