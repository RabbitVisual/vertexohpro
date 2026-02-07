# Vertex Oh Pro! - Plano Mestre de Arquitetura e Produção

## 1. Identidade e Propósito
O **Vertex Oh Pro!** é uma plataforma SaaS independente voltada para a produtividade de professores brasileiros. O foco é automação pedagógica (BNCC), gestão de sala de aula e marketplace de materiais.

## 2. Stack Tecnológica e Restrições Absolutas
* **Framework:** Laravel 12.x (Core)
* **Arquitetura:** Modular (nwidart/laravel-modules v12)
* **Frontend:** Livewire 3.x + Alpine.js + Tailwind CSS v4.1 (Plugin Vite)
* **Persistência Real-time:** Proíbido WebSockets/Reverb. Use **Long Polling (AJAX)** a cada 5-10s (Foco em Hostinger Compartilhada).
* **Local-First:** É terminantemente proibido o uso de CDNs ou scripts externos.
    - Fontes: Inter e Poppins (Local em `resources/fonts/`)
    - Ícones: FontAwesome Pro 7.1.0 Duotone (Local em `resources/fw-pro/`)
    - Bibliotecas JS: IMask, Axios, Alpine (Instalados via NPM e compilados via Vite)

## 3. Design System (Tailwind 4.1 + FA Pro)
* **Paleta de Cores:** Dark Mode padrão (`bg-slate-950`). Acentos em `Indigo-600` para botões e `Emerald-500` para sucessos.
* **Tipografia:** `Poppins` para títulos (h1-h6), `Inter` para corpo e UI.
* **Componente de Ícone (`<x-icon />`):** - Busca definições em `config/icons.php`.
    - Estilo Duotone é o padrão global.
    - Fallback: Se o ícone não existir, renderiza um `<span>` vazio, NUNCA um sinal de exclamação (!).

## 4. Estrutura de Módulos e Responsabilidades
O sistema já possui as pastas dos módulos criadas. O Jules deve implementar a lógica interna seguindo:

1.  **Core:** Componentes globais (Layouts, Icon, LoadingOverlay, Modals, Toasts).
2.  **Admin:** Gestão de usuários, moderação do Marketplace e auditoria.
3.  **TeacherPanel:** Dashboard customizável com widgets arrastáveis (Drag & Drop Alpine.js).
4.  **Planning (BNCC Central):** - Banco de dados local com Habilidades e Competências da BNCC.
    - Editor de Planos com Templates: "Padrão Nacional", "Inovador/Ativo", "Sintético".
5.  **ClassRecord:** Diário de classe, frequências e ciclo de 3 notas por bimestre/trimestre.
6.  **Library:** Marketplace de atividades com sistema de tags e downloads protegidos localmente.
7.  **Billing:** Gateways externos (Stripe/MercadoPago) via API para assinaturas.
8.  **Support:** Tickets e Chat Professor-Suporte via Polling.

## 5. Diretrizes de Codificação para o Jules
- **Migrations:** Use `foreignId()->constrained()` e índices em colunas de busca (ex: `codigo_bncc`).
- **Services:** Regras de negócio complexas (calculo de médias, geração de PDF) devem estar em `Modules/X/app/Services`.
- **Controllers:** Mantenha-os limpos (Skinny Controllers).
- **Segurança:** Limpar máscaras de input (CPF/CNPJ) no backend antes de salvar.
- **Produção:** Todo código deve estar pronto para `npm run build` e deploy na Hostinger.