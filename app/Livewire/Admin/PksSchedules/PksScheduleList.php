<?php

namespace App\Livewire\Admin\PksSchedules;

use App\Models\PksSchedule;
use Livewire\Component;
use Livewire\WithPagination;

class PksScheduleList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'date';
    public $sortDirection = 'asc';

    protected $queryString = ['search', 'perPage', 'sortField', 'sortDirection'];
    protected $listeners = ['pksScheduleAdded' => '$refresh', 'pksScheduleUpdated' => '$refresh'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function deletePksSchedule($id)
    {
        try {
            PksSchedule::destroy($id);
            session()->flash('success', 'Jadwal PKS berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus jadwal PKS: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $pksSchedules = PksSchedule::query()
            ->when($this->search, function ($query) {
                $query->where('activity_name', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('leader_name', 'like', '%' . $this->search . '%')
                    ->orWhere('involved_members', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.admin.pks-schedules.pks-schedule-list', [
            'pksSchedules' => $pksSchedules,
        ])->layout('layouts.admin.app');
    }
}