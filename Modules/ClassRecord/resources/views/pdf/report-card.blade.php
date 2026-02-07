<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
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
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">Vertex Oh Pro! School</div>
        <div class="report-title">Boletim Escolar - {{ $schoolClass->year }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Aluno:</td>
            <td>{{ $student->name }}</td>
            <td class="label">Turma:</td>
            <td>{{ $schoolClass->name }}</td>
        </tr>
        <tr>
            <td class="label">Disciplina:</td>
            <td>{{ $schoolClass->subject }}</td>
            <td class="label">Matrícula:</td>
            <td>{{ $student->registration_number }}</td>
        </tr>
    </table>

    <h3>Desempenho Acadêmico por Bimestre</h3>
    <table class="grades-table">
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
                    $total = $cycleGrades->sum('score'); // Assuming score is the final value
                @endphp
                <tr>
                    <td>{{ $i }}º Bimestre</td>
                    <td>{{ number_format($total, 2) }}</td>
                    <td>
                        @if($total >= 5.0)
                            <span class="status-pass">Aprovado</span>
                        @else
                            <span class="status-fail">Em Aberto / Recuperação</span>
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center;">
        <p>___________________________________</p>
        <p>Assinatura do Responsável</p>
    </div>

    <div class="footer">
        Este documento foi gerado eletronicamente pelo sistema Vertex Oh Pro!.
        @if(isset($signature_hash))
            <br>
            Assinatura Digital (Hash SHA-256): <span class="hash">{{ $signature_hash }}</span>
        @endif
    </div>
</body>
</html>
