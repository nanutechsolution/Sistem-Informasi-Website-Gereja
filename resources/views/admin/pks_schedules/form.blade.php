@php
    $schedule = $schedule ?? null;
@endphp

<div class="space-y-4">
    {{-- Hari --}}
    <div>
        <label for="day_of_week" class="block text-sm font-medium text-gray-700">Hari</label>
        <input type="text" id="day_of_week" name="day_of_week"
            value="{{ old('day_of_week', $schedule->day_of_week ?? '') }}"
            placeholder="Senin, Selasa, ... atau otomatis diisi dari tanggal"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required>
    </div>

    {{-- Tanggal --}}
    <div>
        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
        <input type="date" id="date" name="date"
            value="{{ old('date', isset($schedule) ? \Carbon\Carbon::parse($schedule->date)->format('Y-m-d') : '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required>

    </div>
    {{-- Jam --}}
    <div>
        <label for="time" class="block text-sm font-medium text-gray-700">Jam</label>
        <input type="time" id="time" name="time" value="{{ old('time', $schedule->time ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required>
    </div>

    {{-- Lokasi / Family --}}
    <div>
        <label for="family_id" class="block text-sm font-medium text-gray-700">Lokasi / Family</label>
        <select id="family_id" name="family_id" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="">-- Pilih Lokasi --</option>
            @foreach ($families as $family)
                <option value="{{ $family->id }}" {{ $schedule->families->contains($family->id) ? 'selected' : '' }}>
                    {{ $family->family_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Pemimpin --}}
    <div>
        <label for="leader_id" class="block text-sm font-medium text-gray-700">Pemimpin</label>
        <select id="leader_id" name="leader_id" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="">-- Pilih Pemimpin --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('leader_id', $schedule->leader_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="scripture" class="block text-sm font-medium text-gray-700">Firman Tuhan</label>
        <input type="text" id="scripture" name="scripture" value="{{ old('scripture', $schedule->scripture ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

    </div>

    {{-- Anggota Terlibat --}}
    <div>
        <label for="involved_members" class="block text-sm font-medium text-gray-700">Anggota Terlibat</label>
        <textarea id="involved_members" name="involved_members"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            rows="3">{{ old('involved_members', $schedule->involved_members ?? '') }}</textarea>
    </div>

    {{-- Status --}}
    <div>
        <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
        <select id="is_active" name="is_active"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="1" {{ old('is_active', $schedule->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif
            </option>
            <option value="0" {{ old('is_active', $schedule->is_active ?? 1) == 0 ? 'selected' : '' }}>Nonaktif
            </option>
        </select>
    </div>

</div>
