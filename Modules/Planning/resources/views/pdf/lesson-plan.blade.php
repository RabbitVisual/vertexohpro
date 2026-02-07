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

    @if(isset($sections['objectives']))
        <div class="section-title">Objetivos de Aprendizagem</div>
        <div class="content-box">
            @if(is_array($sections['objectives']))
                <ul>
                    @foreach($sections['objectives'] as $objective)
                        <li>{{ $objective }}</li>
                    @endforeach
                </ul>
            @else
                {!! $sections['objectives'] !!}
            @endif
        </div>
    @endif

    @if(isset($sections['methodology']))
        <div class="section-title">Metodologia</div>
        <div class="content-box">
            @if(is_array($sections['methodology']))
                <ul>
                    @foreach($sections['methodology'] as $method)
                        <li>{{ $method }}</li>
                    @endforeach
                </ul>
            @else
                {!! $sections['methodology'] !!}
            @endif
        </div>
    @endif

    @if(isset($sections['resources']))
        <div class="section-title">Recursos Didáticos</div>
        <div class="content-box">
            @if(is_array($sections['resources']))
                <ul>
                    @foreach($sections['resources'] as $resource)
                        <li>{{ $resource }}</li>
                    @endforeach
                </ul>
            @else
                {!! $sections['resources'] !!}
            @endif
        </div>
    @endif

    @if(isset($sections['assessment']))
        <div class="section-title">Avaliação</div>
        <div class="content-box">
            @if(is_array($sections['assessment']))
                <ul>
                    @foreach($sections['assessment'] as $assessment)
                        <li>{{ $assessment }}</li>
                    @endforeach
                </ul>
            @else
                {!! $sections['assessment'] !!}
            @endif
        </div>
    @endif

    <div style="margin-top: 50px; text-align: center;">
        <p>_______________________________________________________</p>
        <p>Assinatura do Professor</p>
    </div>
</body>
</html>
