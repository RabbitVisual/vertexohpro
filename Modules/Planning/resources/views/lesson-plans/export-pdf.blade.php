<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exportação de Planos de Aula</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .page-break { page-break-after: always; }
        .plan-container { margin-bottom: 2rem; border: 1px solid #ccc; padding: 1rem; border-radius: 8px; }
        h1 { font-size: 1.5rem; border-bottom: 2px solid #333; padding-bottom: 0.5rem; margin-top: 0; }
        .meta { font-size: 0.9rem; color: #666; margin-bottom: 1rem; }
        .section { margin-top: 1rem; }
        .section-title { font-weight: bold; background: #eee; padding: 0.5rem; border-radius: 4px; }
        .content-body { padding: 0.5rem; }
        ul { margin-top: 0.5rem; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            .plan-container { border: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="padding: 1rem; background: #f0f0f0; text-align: center; margin-bottom: 20px; border-radius: 8px;">
        <button onclick="window.print()" style="padding: 0.75rem 1.5rem; cursor: pointer; background: #4f46e5; color: white; border: none; border-radius: 4px; font-weight: bold;">Imprimir / Salvar como PDF</button>
        <p style="margin-top: 0.5rem; font-size: 0.8rem; color: #666;">Dica: Selecione "Salvar como PDF" nas opções de impressão do seu navegador.</p>
    </div>

    @foreach($plans as $plan)
        <div class="plan-container">
            <h1>{{ $plan->title }}</h1>
            <div class="meta">
                <p><strong>Professor:</strong> {{ $plan->user->name ?? 'N/A' }}</p>
                <p><strong>Turma:</strong> {{ $plan->schoolClass->name ?? 'Não vinculada' }}</p>
                <p><strong>Data:</strong> {{ $plan->created_at->format('d/m/Y') }}</p>
                <p><strong>Modelo:</strong> {{ ucfirst($plan->template_type) }}</p>
            </div>

            <div class="content">
                @if(is_array($plan->content))
                    @foreach($plan->content as $key => $value)
                         <div class="section">
                             <div class="section-title">{{ ucfirst($key) }}</div>
                             <div class="content-body">
                                 @if(is_array($value))
                                     <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                 @else
                                     {!! nl2br(e($value)) !!}
                                 @endif
                             </div>
                         </div>
                    @endforeach
                @else
                    <div class="section">
                        <div class="section-title">Conteúdo</div>
                        <div class="content-body">
                            {!! nl2br(e($plan->content)) !!}
                        </div>
                    </div>
                @endif
            </div>

            @if($plan->bncc_skills)
                <div class="section">
                    <div class="section-title">Habilidades BNCC</div>
                    <div class="content-body">
                        <ul>
                        @foreach($plan->bncc_skills as $skill)
                            <li>{{ $skill }}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
