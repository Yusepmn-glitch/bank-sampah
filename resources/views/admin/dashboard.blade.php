<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - Bank Sampah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="riwayat-table-wrap">
                    <table class="riwayat-table w-full">
                        <thead>
                            <tr>
                                <th>Kode Tiket</th>
                                <th>Nama Warga</th>
                                <th>Jenis</th>
                                <th>Berat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_setoran as $setoran)
                            <tr>
                                <td>{{ $setoran->kode_tiket }}</td>
                                <td>{{ $setoran->nama }}</td>
                                <td>{{ $setoran->jenis_sampah }}</td>
                                <td>{{ $setoran->berat }} kg</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($setoran->status) }}">
                                        {{ $setoran->status }}
                                    </span>
                                </td>
                                <td class="flex space-x-2">
                                    <form action="{{ route('admin.update-status', $setoran->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="text-xs p-1 border rounded">
                                            <option value="Menunggu" {{ $setoran->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="Diproses" {{ $setoran->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="Selesai" {{ $setoran->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Ditolak" {{ $setoran->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </form>
                                    <form action="{{ route('admin.destroy', $setoran->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
