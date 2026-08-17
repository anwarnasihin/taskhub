<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Tugas - {{ $project->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #111; margin: 30px; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h2 { margin: 0; font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 13px; color: #555; }
        .divider { border-bottom: 2px solid #000; margin: 15px 0 25px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 8px 12px; text-align: left; font-size: 13px; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .status-selesai { color: #008000; font-weight: bold; }
        .status-belum { color: #FF0000; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Daftar Tugas</h2>
        <p>Project: <strong>{{ $project->name }}</strong></p>
        <p>Dicetak pada: {{ date('d M Y H:i') }}</p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 42%;">Judul Tugas</th>
                <th style="width: 18%;">Prioritas</th>
                <th style="width: 18%;">Tenggat Waktu</th>
                <th style="width: 14%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($project->tasks as $index => $task)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $task->title }}</td>
                    <td class="text-center">{{ ucfirst($task->priority) }}</td>
                    <td class="text-center">{{ $task->due_date ? $task->due_date->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">
                        @if($task->is_completed)
                            <span class="status-selesai">Selesai</span>
                        @else
                            <span class="status-belum">Belum Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #666;">Belum ada tugas pada project ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
