<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Boletim Escolar - {{ $schoolClass->year }}</h1>
        <p>Turma: {{ $schoolClass->name }} | Disciplina: {{ $schoolClass->subject }}</p>
        <h2>Aluno: {{ $student->name }}</h2>
        <p>Matrícula: {{ $student->registration_number }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Ciclo (Bimestre)</th>
                <th>Nota Final</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 4; $i++)
                @php
                    $cycleGrades = $student->grades->where('cycle', $i);
                    $total = $cycleGrades->sum('value');
                    // Simple average or sum logic? "Ciclo de 3 notas" implies sum or avg. Let's assume sum for now or just display.
                    // Assuming grades are fragments of the total score.
                @endphp
                <tr>
                    <td>{{ $i }}º Bimestre</td>
                    <td>{{ number_format($total, 2) }}</td>
                    <td>{{ $cycleGrades->whereNotNull('locked_at')->count() > 0 ? 'Fechado' : 'Em Aberto' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center;">
        <p>___________________________________</p>
        <p>Assinatura do Responsável</p>
    </div>
</body>
</html>
