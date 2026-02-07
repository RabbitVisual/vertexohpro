<?php

namespace Modules\Planning\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Planning\Models\BnccHabilidade;

class PlanningDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['EF01LP01', 'Reconhecer que textos são lidos e escritos da esquerda para a direita e de cima para baixo da página.', 'Língua Portuguesa', '1º Ano', 'Protocolos de leitura'],
            ['EF01LP02', 'Escrever, espontaneamente ou por ditado, palavras e frases de forma alfabética – usando letras/grafemas que representem fonemas.', 'Língua Portuguesa', '1º Ano', 'Escrita autônoma'],
            ['EF01LP03', 'Observar escritas convencionais, comparando-as às suas produções escritas, percebendo semelhanças e diferenças.', 'Língua Portuguesa', '1º Ano', 'Escrita compartilhada'],
            ['EF01LP04', 'Distinguir as letras do alfabeto de outros sinais gráficos.', 'Língua Portuguesa', '1º Ano', 'Conhecimento do alfabeto'],
            ['EF01LP05', 'Reconhecer o sistema de escrita alfabética como representação dos sons da fala.', 'Língua Portuguesa', '1º Ano', 'Construção do sistema alfabético'],
            ['EF01LP06', 'Segmentar oralmente palavras em sílabas.', 'Língua Portuguesa', '1º Ano', 'Consciência fonológica'],
            ['EF01LP07', 'Identificar fonemas e sua representação por letras.', 'Língua Portuguesa', '1º Ano', 'Fonemas e grafemas'],
            ['EF01LP08', 'Relacionar elementos sonoros (sílabas, fonemas, partes de palavras) com sua representação escrita.', 'Língua Portuguesa', '1º Ano', 'Correspondência fonema-grafema'],
            ['EF01LP09', 'Comparar palavras, identificando semelhanças e diferenças entre sons de sílabas iniciais, mediais e finais.', 'Língua Portuguesa', '1º Ano', 'Consciência silábica'],
            ['EF01LP10', 'Nomear as letras do alfabeto e recitá-lo na ordem das letras.', 'Língua Portuguesa', '1º Ano', 'Conhecimento do alfabeto'],
            ['EF01MAT01', 'Utilizar números naturais como indicador de quantidade ou de ordem em diferentes situações cotidianas.', 'Matemática', '1º Ano', 'Números naturais'],
            ['EF01MAT02', 'Contar de maneira exata ou aproximada, utilizando diferentes estratégias como o pareamento e outros agrupamentos.', 'Matemática', '1º Ano', 'Contagem'],
            ['EF01MAT03', 'Estimar e comparar quantidades de objetos de dois conjuntos (em torno de 20 elementos), por estimativa e/ou por correspondência.', 'Matemática', '1º Ano', 'Comparação de quantidades'],
            ['EF01MAT04', 'Contar a quantidade de objetos de coleções até 100 unidades e apresentar o resultado por registros verbais e simbólicos.', 'Matemática', '1º Ano', 'Sistema de numeração'],
            ['EF01MAT05', 'Comparar números naturais de até duas ordens em situações cotidianas, com e sem suporte da reta numérica.', 'Matemática', '1º Ano', 'Ordem numérica'],
            ['EF01MAT06', 'Construir fatos básicos da adição e utilizá-los em procedimentos de cálculo para resolver problemas.', 'Matemática', '1º Ano', 'Adição'],
            ['EF01MAT07', 'Compor e decompor número de até duas ordens, por meio de diferentes adições, com o suporte de material manipulável.', 'Matemática', '1º Ano', 'Composição e decomposição'],
            ['EF01MAT08', 'Resolver e elaborar problemas de adição e de subtração, envolvendo números de até dois algarismos.', 'Matemática', '1º Ano', 'Resolução de problemas'],
            ['EF01CI01', 'Comparar características de diferentes materiais presentes em objetos de uso cotidiano.', 'Ciências', '1º Ano', 'Materiais e seus usos'],
            ['EF01CI02', 'Localizar, nomear e representar graficamente (por meio de desenhos) partes do corpo humano e explicar suas funções.', 'Ciências', '1º Ano', 'Corpo humano'],
            ['EF01CI03', 'Discutir as razões pelas quais os hábitos de higiene do corpo (lavar as mãos antes de comer, escovar os dentes, limpar os olhos, o nariz e as orelhas etc.) são necessários para a manutenção da saúde.', 'Ciências', '1º Ano', 'Saúde e higiene'],
            ['EF01CI04', 'Comparar características físicas entre os colegas, reconhecendo a diversidade e a importância da valorização, do acolhimento e do respeito às diferenças.', 'Ciências', '1º Ano', 'Respeito à diversidade'],
            ['EF01HI01', 'Identificar aspectos do seu crescimento por meio do registro das lembranças particulares ou de lembranças dos membros de sua família e/ou de sua comunidade.', 'História', '1º Ano', 'História pessoal'],
            ['EF01HI02', 'Identificar a relação entre as suas histórias e as histórias de sua família e de sua comunidade.', 'História', '1º Ano', 'Memória e identidade'],
            ['EF01HI03', 'Descrever e distinguir os seus papéis e responsabilidades relacionados à família, à escola e à comunidade.', 'História', '1º Ano', 'Vida em comunidade'],
            ['EF01HI04', 'Identificar as diferenças entre os variados ambientes em que vive (doméstico, escolar e da comunidade), reconhecendo as especificidades dos hábitos e das regras que os regem.', 'História', '1º Ano', 'Ambientes de convivência'],
            ['EF01GE01', 'Descrever características observadas de seus lugares de vivência (moradia, escola etc.) e identificar semelhanças e diferenças entre esses lugares.', 'Geografia', '1º Ano', 'Lugares de vivência'],
            ['EF01GE02', 'Identificar semelhanças e diferenças entre jogos e brincadeiras de diferentes épocas e lugares.', 'Geografia', '1º Ano', 'Jogos e brincadeiras'],
            ['EF01GE03', 'Identificar e relatar semelhanças e diferenças de usos do espaço público (praças, parques) para o lazer e diferentes manifestações.', 'Geografia', '1º Ano', 'Espaço público'],
            ['EF01GE04', 'Discutir e elaborar, coletivamente, regras de convívio em diferentes espaços (sala de aula, escola etc.).', 'Geografia', '1º Ano', 'Regras de convívio'],
            ['EF02LP01', 'Utilizar, ao produzir o texto, grafia correta de palavras conhecidas ou com estruturas silábicas simples.', 'Língua Portuguesa', '2º Ano', 'Ortografia'],
            ['EF02LP02', 'Segmentar palavras em sílabas e remover e substituir sílabas iniciais, mediais ou finais para criar novas palavras.', 'Língua Portuguesa', '2º Ano', 'Consciência fonológica'],
            ['EF02LP03', 'Ler e escrever palavras com correspondências regulares diretas entre grafemas e fonemas.', 'Língua Portuguesa', '2º Ano', 'Leitura e escrita'],
            ['EF02LP04', 'Ler e escrever corretamente palavras com sílabas CV, V, CVC, CCV, identificando que existem vogais em todas as sílabas.', 'Língua Portuguesa', '2º Ano', 'Estrutura silábica'],
            ['EF02MAT01', 'Comparar e ordenar números naturais (até a ordem de centenas) pela compreensão de características do sistema de numeração decimal.', 'Matemática', '2º Ano', 'Sistema decimal'],
            ['EF02MAT02', 'Fazer estimativas por meio de estratégias diversas a respeito da quantidade de objetos de coleções e registrar o resultado da contagem.', 'Matemática', '2º Ano', 'Estimativa'],
            ['EF02MAT03', 'Comparar quantidades de objetos de dois conjuntos, por estimativa e/ou por correspondência (um a um, dois a dois, entre outros).', 'Matemática', '2º Ano', 'Comparação'],
            ['EF02MAT04', 'Compor e decompor números naturais de até três ordens, com suporte de material manipulável, por meio de diferentes adições.', 'Matemática', '2º Ano', 'Composição numérica'],
            ['EF02CI01', 'Identificar de que materiais (metais, madeira, vidro etc.) são feitos os objetos que fazem parte da vida cotidiana.', 'Ciências', '2º Ano', 'Propriedades dos materiais'],
            ['EF02CI02', 'Propor o uso de diferentes materiais para a construção de objetos de uso cotidiano, tendo em vista algumas propriedades desses materiais.', 'Ciências', '2º Ano', 'Engenharia e materiais'],
            ['EF02HI01', 'Reconhecer espaços de sociabilidade e identificar os motivos que aproximam e separam as pessoas em diferentes grupos sociais ou de parentesco.', 'História', '2º Ano', 'Grupos sociais'],
            ['EF02HI02', 'Identificar e descrever práticas e papéis sociais que as pessoas exercem em diferentes comunidades.', 'História', '2º Ano', 'Papéis sociais'],
            ['EF02GE01', 'Descrever a história das migrações no bairro ou comunidade em que vive.', 'Geografia', '2º Ano', 'Migrações'],
            ['EF02GE02', 'Comparar costumes e tradições de diferentes populações inseridas no bairro ou comunidade em que vive.', 'Geografia', '2º Ano', 'Cultura local'],
            ['EF03LP01', 'Ler e escrever palavras com correspondências regulares contextuais (c/qu; g/gu; r/rr; s/ss; o/u; e/i).', 'Língua Portuguesa', '3º Ano', 'Ortografia contextual'],
            ['EF03MAT01', 'Ler, escrever e comparar números naturais de até a ordem de unidade de milhar, estabelecendo relações entre os registros numéricos e em língua materna.', 'Matemática', '3º Ano', 'Milhares'],
            ['EF03CI01', 'Produzir diferentes sons a partir da vibração de variados objetos e identificar variáveis que influem nesse fenômeno.', 'Ciências', '3º Ano', 'Som e vibração'],
            ['EF03HI01', 'Identificar os grupos populacionais que formam a cidade, o município e a região, as relações estabelecidas entre eles e os eventos que marcam a formação da cidade.', 'História', '3º Ano', 'Formação das cidades'],
            ['EF03GE01', 'Identificar e comparar aspectos culturais dos grupos sociais de seus lugares de vivência, seja na cidade, seja no campo.', 'Geografia', '3º Ano', 'Cidade e campo'],
            ['EF04LP01', 'Grafar palavras utilizando regras de correspondência fonema-grafema regulares diretas e contextuais.', 'Língua Portuguesa', '4º Ano', 'Ortografia complexa'],
        ];

        foreach ($skills as $skill) {
            BnccHabilidade::firstOrCreate(
                ['codigo' => $skill[0]],
                [
                    'descricao' => $skill[1],
                    'componente_curricular' => $skill[2],
                    'ano_faixa' => $skill[3],
                    'objetos_conhecimento' => [$skill[4]]
                ]
            );
        }
    }
}
