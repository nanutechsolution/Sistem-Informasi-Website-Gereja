<?php

namespace App\Livewire\Admin\PksSchedules;

use App\Models\PksSchedule; // Pastikan model PksSchedule sudah ada
use Livewire\Component;

class PksScheduleForm extends Component
{
    public $pksScheduleId;
    public $activity_name;
    public $date;
    public $time;
    public $location;
    public $leader_name;
    public $description;
    public $involved_members; // Contoh: Array string atau text
    public $is_active = true;

    protected $rules = [
        'activity_name' => 'required|string|max:255',
        'date' => 'required|date',
        'time' => 'required',
        'location' => 'required|string|max:255',
        'leader_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'involved_members' => 'nullable|string', // Atau 'nullable|array' jika akan disimpan sebagai JSON
        'is_active' => 'boolean',
    ];

    public function mount($pksSchedule = null)
    {
        if ($pksSchedule) {
            $this->pksScheduleId = $pksSchedule->id;
            $this->activity_name = $pksSchedule->activity_name;
            $this->date = $pksSchedule->date->format('Y-m-d');
            $this->time = $pksSchedule->time->format('H:i');
            $this->location = $pksSchedule->location;
            $this->leader_name = $pksSchedule->leader_name;
            $this->description = $pksSchedule->description;
            $this->involved_members = $pksSchedule->involved_members;
            $this->is_active = $pksSchedule->is_active;
        } else {
            // Default values for new form
            $this->date = now()->format('Y-m-d');
            $this->time = now()->format('H:i');
        }
    }

    public function savePksSchedule()
    {
        $this->validate();

        $data = [
            'activity_name' => $this->activity_name,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'leader_name' => $this->leader_name,
            'description' => $this->description,
            'involved_members' => $this->involved_members,
            'is_active' => $this->is_active,
        ];

        if ($this->pksScheduleId) {
            $pksSchedule = PksSchedule::find($this->pksScheduleId);
            $pksSchedule->update($data);
            session()->flash('message', ['type' => 'success', 'content' => 'Jadwal PKS berhasil diperbarui!']);
            $this->dispatch('pksScheduleUpdated'); // Untuk refresh daftar
        } else {
            PksSchedule::create($data);
            session()->flash('message', ['type' => 'success', 'content' => 'Jadwal PKS berhasil ditambahkan!']);
            $this->dispatch('pksScheduleAdded'); // Untuk refresh daftar
        }

        return redirect()->route('admin.pks-schedules.index');
    }
    public function render()
    {
        $header = $this->pksScheduleId ? 'Edit Jadwal PKS' : 'Tambah Jadwal PKS Baru';
        return view('livewire.admin.pks-schedules.pks-schedule-form')->layout('layouts.admin.app', ['header' => $header]); // <-- INI CARA LIVEWIRE MENGGUNAKAN LAYOUT
    }
}