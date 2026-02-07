<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; color: #000; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; font-weight: bold; width: 30%; }
        .section-title { font-weight: bold; text-transform: uppercase; background-color: #e0e0e0; padding: 5px; border: 1px solid #000; margin-top: 10px; }
        .content-box { border: 1px solid #000; padding: 10px; margin-bottom: 10px; min-height: 50px; }
        ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Planejamento de Aula</h1>
        <p>Documento Oficial - Gerado em {{ $date }}</p>
    </div>

    <table>
        <tr>
            <th>Título da Aula</th>
            <td>{{ $plan->title }}</td>
        </tr>
        <tr>
            <th>ID do Plano</th>
            <td>#{{ $plan->id }}</td>
        </tr>
    </table>

    @php
        $sections = $plan->sections ?? [];
    @endphp

    @foreach($sections as $section)
        @if(isset($section['title']) && isset($section['content']))
            <div class="section-title">{{ $section['title'] }}</div>
            <div class="content-box">
                {!! nl2br(e($section['content'])) !!}
            </div>
        @endif
    @endforeach

    <div style="margin-top: 50px; text-align: center;">
        <p>_______________________________________________________</p>
        <p>Assinatura do Professor</p>
    </div>
</body>
</html>
