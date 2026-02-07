<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Boletim - {{ $student->name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #1a202c; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #718096; }

        .student-info { margin-bottom: 30px; background: #f7fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .info-row { margin-bottom: 10px; }
        .label { font-weight: bold; color: #4a5568; margin-right: 5px; }

        .grades-section { margin-bottom: 40px; }
        .chart-container {
            display: table; /* Use table for PDF layout stability */
            width: 100%;
            height: 220px;
            border-bottom: 1px solid #cbd5e0;
            padding-bottom: 10px;
            margin-top: 20px;
            table-layout: fixed;
        }
        .bar-group {
            display: table-cell;
            vertical-align: bottom;
            text-align: center;
            height: 220px;
        }
        .bar {
            width: 40px;
            background-color: #4299e1;
            margin: 0 auto;
            border-radius: 4px 4px 0 0;
            position: relative;
        }
        .low-grade { background-color: #f56565 !important; }
        .bar-label { margin-top: 10px; font-weight: bold; font-size: 14px; color: #4a5568; }
        .bar-value {
            position: absolute;
            top: -20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #2d3748;
        }
        .recovery-info { font-size: 10px; color: #e53e3e; margin-top: 2px; }

        .attendance-section { margin-bottom: 30px; page-break-inside: avoid; }
        .signature-section { margin-top: 60px; text-align: center; page-break-inside: avoid; }
        .signature-img { max-width: 200px; max-height: 80px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
        .signature-line { border-top: 1px solid #718096; width: 300px; margin: 0 auto; padding-top: 5px; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { background-color: #edf2f7; color: #4a5568; font-weight: bold; }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .status-ok { background-color: #c6f6d5; color: #22543d; }
        .status-warn { background-color: #fed7d7; color: #822727; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Desempenho Escolar</h1>
        <p>Vertex Oh Pro! - Sistema de Gestão Escolar</p>
        <p>Gerado em: {{ $generatedAt }}</p>
    </div>

    <div class="student-info">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;">
                    <span class="label">Aluno:</span> {{ $student->name }}
                </td>
                <td style="border: none; width: 50%;">
                    <span class="label">Turma:</span> {{ $class->name }}
                </td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">
                    <span class="label">Disciplina:</span> {{ $class->subject }}
                </td>
                <td style="border: none;">
                    <span class="label">Ano Letivo:</span> {{ $class->year }}
                </td>
            </tr>
        </table>
    </div>

    <div class="grades-section">
        <h3>Evolução de Notas por Ciclo</h3>
        <div class="chart-container">
            @foreach($gradesData as $cycle => $data)
                @php
                    $val = $data['final'] ?? 0;
                    $height = $val * 20; // 10 -> 200px
                    $isLow = $val < 5.0 && $data['final'] !== null;
                @endphp
                <div class="bar-group">
                    <div class="bar {{ $isLow ? 'low-grade' : '' }}" style="height: {{ $height }}px;">
                        @if($data['final'] !== null)
                            <span class="bar-value">{{ number_format($val, 1, ',', '.') }}</span>
                        @endif
                    </div>
                    <div class="bar-label">{{ $cycle }}º Ciclo</div>
                    @if($data['recovery'] !== null)
                        <div class="recovery-info">(Rec: {{ number_format($data['recovery'], 1, ',', '.') }})</div>
                    @endif
                </div>
            @endforeach
        </div>

        <table style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Ciclo</th>
                    <th>Média Original</th>
                    <th>Recuperação</th>
                    <th>Nota Final</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gradesData as $cycle => $data)
                    <tr>
                        <td>{{ $cycle }}º Ciclo</td>
                        <td>{{ $data['average'] ? number_format($data['average'], 1, ',', '.') : '-' }}</td>
                        <td>{{ $data['recovery'] ? number_format($data['recovery'], 1, ',', '.') : '-' }}</td>
                        <td style="font-weight: bold; color: {{ ($data['final'] !== null && $data['final'] < 5.0) ? '#e53e3e' : '#2d3748' }}">
                            {{ $data['final'] ? number_format($data['final'], 1, ',', '.') : '-' }}
                        </td>
                        <td>
                            @if($data['final'] === null)
                                -
                            @elseif($data['final'] >= 5.0)
                                <span class="status-badge status-ok">Aprovado</span>
                            @else
                                <span class="status-badge status-warn">Recuperação</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="attendance-section">
        <h3>Frequência</h3>
        <p><strong>Presença Global:</strong> {{ $attendancePercentage }}%</p>

        <h4>Observações do Professor</h4>
        @php
            $observations = $student->attendances()
                ->whereNotNull('observation')
                ->where('observation', '!=', '')
                ->orderBy('date', 'desc')
                ->get();
        @endphp

        @if($observations->isEmpty())
            <p style="color: #718096; font-style: italic; border: 1px dashed #cbd5e0; padding: 10px; border-radius: 4px;">Nenhuma observação registrada.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width: 120px;">Data</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($observations as $obs)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($obs->date)->format('d/m/Y') }}</td>
                            <td>{{ $obs->observation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="signature-section">
        @if($signature)
            <img src="{{ $signature }}" class="signature-img" alt="Assinatura Digital">
        @else
            <div style="height: 60px;"></div>
        @endif
        <div class="signature-line">
            {{ auth()->user()->first_name ?? 'Professor(a)' }} {{ auth()->user()->last_name ?? '' }}
        </div>
        <p style="font-size: 12px; color: #a0aec0; margin-top: 5px;">Assinado digitalmente em {{ $generatedAt }}</p>
    </div>
</body>
</html>
