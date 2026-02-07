<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 2cm;
            margin-bottom: 2.5cm; /* Space for footer */
        }
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; color: #000; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10pt; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; page-break-inside: avoid; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; font-weight: bold; width: 30%; }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            background-color: #e0e0e0;
            padding: 5px;
            border: 1px solid #000;
            margin-top: 10px;
            page-break-after: avoid; /* Keep with content */
        }
        .content-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
            min-height: 50px;
            page-break-inside: auto; /* Allow break inside large text blocks */
        }

        ul { margin: 0; padding-left: 20px; }

        /* Footer for Page Numbers */
        footer {
            position: fixed;
            bottom: -2cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            text-align: center;
            font-size: 10pt;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <footer>
        <script type="text/php">
            if (isset($pdf)) {
                $x = 297.5; // Center of A4 width approx
                $y = 820;   // Bottom of A4 height approx
                $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
                $font = $fontMetrics->get_font("Times New Roman", "normal");
                $size = 10;
                $color = array(0,0,0);
                $word_space = 0.0;
                $char_space = 0.0;
                $angle = 0.0;
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
    </footer>

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
        $sections = $plan->sections ?: ($plan->content ?: []);
    @endphp

    @foreach($sections as $section)
        @if(isset($section['title']) && isset($section['content']))
            <div class="section-title">{{ $section['title'] }}</div>
            <div class="content-box">
                {!! $section['content'] !!}
            </div>
        @endif
    @endforeach

    <div style="margin-top: 50px; text-align: center; page-break-inside: avoid;">
        <p>_______________________________________________________</p>
        <p>Assinatura do Professor</p>
    </div>
</body>
</html>
