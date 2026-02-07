<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Boletim Escolar - {{ $student->name }}</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .school-name { font-size: 24px; font-weight: bold; color: #4f46e5; }
        .report-title { font-size: 18px; margin-top: 5px; }

        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .label { font-weight: bold; color: #666; }

        .grades-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .grades-table th, .grades-table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        .grades-table th { background-color: #f3f4f6; color: #1f2937; }

        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; color: #9ca3af; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .hash { font-family: monospace; word-break: break-all; margin-top: 5px; }

        .status-pass { color: green; font-weight: bold; }
        .status-fail { color: red; font-weight: bold; }
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
        <div class="school-name">Vertex Oh Pro! School</div>
        <div class="report-title">Boletim Escolar</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Aluno:</td>
            <td>{{ $student->name }}</td>
            <td class="label">Turma:</td>
            <td>{{ $school_class->name }}</td>
        </tr>
        <tr>
            <td class="label">Data de Emissão:</td>
            <td>{{ $generated_at->format('d/m/Y H:i') }}</td>
            <td class="label">ID do Relatório:</td>
            <td>{{ $report_id }}</td>
        </tr>
    </table>

    <h3>Desempenho Acadêmico</h3>
    <table class="grades-table">
        <thead>
            <tr>
                <th>Disciplina</th>
                <th>Habilidade BNCC</th>
                <th>Nota</th>
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
            @foreach($grades as $grade)
            <tr>
                <td>{{ $grade->subject }}</td>
                <td>{{ $grade->bncc_skill_code ?? '-' }}</td>
                <td>{{ number_format($grade->score, 1) }}</td>
                <td>
                    @if($grade->score >= 5.0)
                        <span class="status-pass">Aprovado</span>
                    @else
                        <span class="status-fail">Recuperação</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Frequência</h3>
    <p>Presenças: {{ $attendance['present'] }} | Faltas: {{ $attendance['absent'] }} | Total: {{ $attendance['total'] }}</p>
    <p>Percentual de Frequência: {{ $attendance['total'] > 0 ? round(($attendance['present'] / $attendance['total']) * 100, 1) : 0 }}%</p>

    <div class="footer">
        Assinatura Digital (Hash SHA-256) para Validação de Auditoria:<br>
        <div class="hash">{{ $signature_hash }}</div>
        <br>
        Este documento foi gerado eletronicamente pelo sistema Vertex Oh Pro!.
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
