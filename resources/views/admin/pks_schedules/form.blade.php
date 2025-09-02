@php
    $schedule = $schedule ?? null;
@endphp

<div class="mb-4">
    <label for="activity_name" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
    <input type="text" id="activity_name" name="activity_name"
        value="{{ old('activity_name', $schedule->activity_name ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        required>
</div>

<div class="mb-4">
    <label for="day_of_week" class="block text-sm font-medium text-gray-700">Hari</label>
    <input type="text" id="day_of_week" name="day_of_week"
        value="{{ old('day_of_week', $schedule->day_of_week ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        required>
</div>

<div class="mb-4">
    <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
    <input type="date" id="date" name="date" value="{{ old('date', $schedule->date ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        required>
</div>

<div class="mb-4">
    <label for="time" class="block text-sm font-medium text-gray-700">Jam</label>
    <input type="time" id="time" name="time" value="{{ old('time', $schedule->time ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        required>
</div>

<div class="mb-4">
    <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
    <input type="text" id="location" name="location" value="{{ old('location', $schedule->location ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        required>
</div>

<div class="mb-4">
    <label for="leader_name" class="block text-sm font-medium text-gray-700">Pemimpin</label>
    <input type="text" id="leader_name" name="leader_name"
        value="{{ old('leader_name', $schedule->leader_name ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        required>
</div>

<div class="mb-4">
    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
    <textarea id="description" name="description"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $schedule->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label for="involved_members" class="block text-sm font-medium text-gray-700">Anggota Terlibat</label>
    <textarea id="involved_members" name="involved_members"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('involved_members', $schedule->involved_members ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
    <select id="is_active" name="is_active"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        <option value="1" {{ old('is_active', $schedule->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ old('is_active', $schedule->is_active ?? 1) == 0 ? 'selected' : '' }}>Nonaktif
        </option>
    </select>
</div>
