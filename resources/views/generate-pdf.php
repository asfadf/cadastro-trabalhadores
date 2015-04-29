<?php
    // Retira o campo vínculo de "$fields" para mostrar separado
    $vinculo = null;
    foreach ($fields as $key => $field) {
        if ($field['external_id'] === 'tipo-de-associado') {
            $vinculo = $field;
            unset($fields[$key]);
            break;
        }
    }

    // Trata a data de nascimento do formato "YYYY-mm-dd HH:mm:ss" para "dd/mm/YYYY"
    $segments = explode(' ', $volunteer['data-de-nascimento']);
    $parts = explode('-', $segments[0]);
    $volunteer['data-de-nascimento'] = $parts[2].'/'.$parts[1].'/'.$parts[0];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ficha Cadastral e Termo de Adesão ao Serviço Voluntário</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <style type="text/css">
        body {
            font-size: 14px;
            line-height: 2em;
        }
        .button-print {
            margin: 10px 0;
            text-align: center;
        }
        header, footer {
            margin-bottom: 40px;
        }
        article {
            line-height: 1.5em;
        }
        header h1 {
            font-size: 1.3em;
            font-weight: bold;
            text-align: center;
        }
        strong {
            font-weight: normal;
        }
        .field {
            line-height: 1em;
            margin-bottom: 20px;
        }
        .textfield {
            border-bottom: 1px solid #000000;
        }
        .textfield strong {
            position: relative !important;
            top: 1px !important;
            background: #FFFFFF !important;
            padding-right: 10px !important;
        }
        .textfield-value {
            position: relative;
            top: -5px;
        }
        .multiple .multiple-list {
            display: block;
        }
        .multiple strong,
        .multiple .multiple-list span {
            margin-bottom: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="button-print">
        <button class="btn btn-lg btn-primary hidden-print" onclick="window.print();">Imprimir esta Ficha Cadastral</button>
    </div>

    <div class="container">
        <header class="row">
            <div class="col-xs-2 col-sm-2 col-md-2">
                <img src="/images/logo-asfa.png" class="img-responsive">
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <h1>Ficha Cadastral e Termo de Adesão ao Serviço Voluntário</h1>
                <div class="text-right">
                    <strong><?= $vinculo['label'] ?>:</strong>
                    <?php foreach ($field['settings']['options'] as $option) : ?>
                    <span>
                        <?= getOptionString($option['id'], $volunteer[$field['external_id']]) ?> <?= $option['text'] ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </header>

        <div class="row">
        <?php foreach ($fields as $field): ?>
            <?php if (!isset($volunteer[$field['external_id']])) { continue; } ?>

                <div class="field <?= getFieldGridClass($field) ?>">
                    <div class="<?= getFieldContainerClass($field) ?>">
                        <strong><?= $field['label'] ?>:</strong>
                        <?php if ($field['type'] !== 'category') : ?>
                            <span class="textfield-value">
                                <?= $volunteer[$field['external_id']] ?>
                            </span>
                        <?php elseif ($field['type'] === 'category') : ?>
                            <span class="multiple-list">
                            <?php foreach ($field['settings']['options'] as $option) : ?>
                                <span class="<?= $field['settings']['multiple'] === true ? 'col-xs-6 col-sm-6 col-md-6' : '' ?>">
                                    <?= getOptionString($option['id'], $volunteer[$field['external_id']]) ?> <?= $option['text'] ?>
                                </span>
                            <?php endforeach; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
        <?php endforeach; ?>
        </div>

        <footer class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <p>Declaro que estou ciente de que executo o serviço voluntário nos termos da Lei 9.608, de 18 de
                fevereiro de 1998, junto à Associação Francisco de Assis (ASFA), inscrita sob o CNPJ 10.486.055/0001-07, e
                cuja sede se localiza em Quadra 12 Conjunto D Lote 45 Estrutural/DF.</p>
                <p class="text-right">Data de preenchimento: Brasília/DF, _____/_______________/__________.</p>
                <p class="text-center" style="margin-top: 30px;">
                _______________________________<br>
                Assinatura
                </p>
            </div>

            <div class="row text-center">
                <p class="col-xs-4 col-sm-4 col-md-4">
                _______________________________<br>
                Leonardo Possideli Moreira<br>
                Presidente da ASFA<br>
                Gestão 2014-2016
                </p>
                <p class="col-xs-4 col-sm-4 col-md-4">
                _______________________<br>
                _______________________<br>
                _______________________<br>
                1a Testemunha
                </p>
                <p class="col-xs-4 col-sm-4 col-md-4">
                _______________________<br>
                _______________________<br>
                _______________________<br>
                2a Testemunha
                </p>
            </div>
        </footer>

        <article class="row">
            <div class="col-md-12">
                <h4>Fonte: Estatuto da ASFA</h4>

                <p><em>Art. 1o</em> A Associação Francisco de Assis, também designada pela sigla: ASFA, constituída em 21 de março de
                2008 sob a forma de associação, é uma pessoa jurídica de direito privado, filantrópica, beneficente, sem fins
                lucrativos, e duração por tempo indeterminado, com sede a quadra 12 Conjunto “D” lote 45, na cidade
                Estrutural - Distrito Federal.</p>

                <p><em>Art. 2o</em> Na certeza da proteção de Francisco de Assis, espírito de luz e bondade, que inspirou sua criação, a
                ASFA tem por objetivo:<br>
                a) praticar a caridade cristã, por meio da oração e da ação;<br>
                b) amenizar o sofrimento, restituir a dignidade humana e promover o resgate da cidadania dos seus
                assistidos.</p>

                <p>Parágrafo único<br>

                A ASFA não distribui entre os seus associados, conselheiros, diretores ou doadores eventuais excedentes
                operacionais, brutos ou líquidos, dividendos, bonificações, participações ou parcelas do seu patrimônio,
                auferidos mediante o exercício de suas atividades: todas essas verbas são integralmente aplicadas na
                consecução do seu objetivo social.</p>

                <h4 class="text-center">LEI No 9.608, DE 18 DE FEVEREIRO DE 1998</h4>

                <p class="text-right">Dispõe sobre o serviço voluntário e dá outras providências</p>

                <p>O Presidente da República<br>
                Faço saber que o Congresso Nacional decreta e eu sanciono a seguinte Lei:</p>

                <p><em>Art. 1o</em> Considera-se serviço voluntário, para fins desta Lei, a atividade não remunerada, prestada por pessoa
                física a entidade pública de qualquer natureza, ou a instituição privada de fins não lucrativos, que tenha
                objetivos cívicos, culturais, educacionais, científicos, recreativos ou de assistência social, inclusive
                mutualidade.<br>

                Parágrafo único<br>

                O serviço voluntário não gera vínculo empregatício, nem obrigação de natureza trabalhista, previdenciária
                ou afim.</p>

                <p><em>Art. 2o</em> O serviço voluntário será exercido mediante a celebração de termo de adesão entre a entidade,
                pública ou privada, e o prestador do serviço voluntário, dele devendo constar o objeto e as condições de seu
                exercício.</p>

                <p><em>Art. 3o</em> O prestador do serviço voluntário poderá ser ressarcido pelas despesas que comprovadamente
                realizar no desempenho das atividades voluntárias.<br>
                Parágrafo único<br>
                As despesas a serem ressarcidas deverão estar expressamente autorizadas pela entidade a que for prestado
                o serviço voluntário.</p>

                <p><em>Art. 4o</em> Esta Lei entra em vigor na data de sua publicação.</p>

                <p><em>Art. 5o</em> Revogam-se as disposições em contrário.</p>

                <p>Brasília, 18 de fevereiro de 1998; 177o da Independência e 110o da República.</p>

                <p class="text-center">FERNANDO HENRIQUE CARDOSO</p>
            </div>
        </article>

        <div class="button-print">
            <button class="btn btn-lg btn-primary hidden-print" onclick="window.print();">Imprimir esta Ficha Cadastral</button>
        </div>

    </div>
</body>
</html>

<?php

function getOptionString($optionId, $data) {
    $values = [
        'checked' => '[X]',
        'unchecked' => '[&nbsp;&nbsp;]'
    ];

    if (is_array($data)) { // Multiple
        $checked = in_array($optionId, $data);
    } else {
        $checked = $optionId === $data;
    }

    return $checked ? $values['checked'] : $values['unchecked'];
}
function getFieldGridClass($field) {
    if ($field['delta'] === 0 ||
        $field['external_id'] === 'endereco-completo') {
        return 'col-md-12';
    } else if (isset($field['settings']['multiple']) && $field['settings']['multiple'] === true) {
        return 'col-xs-12 col-sm-12 col-md-12 clearfix';
    }

    return 'col-xs-6 col-sm-6 col-md-6';
}

function getFieldContainerClass($field) {
    if ($field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'date') {
        return 'textfield';
    }else if (isset($field['settings']['multiple']) && $field['settings']['multiple'] === true) {
        return 'multiple';
    }
}