<?php
/*
 * Complete the 'formacaoDeTime' function below.
 *
 * The function is expected to return a LONG_INTEGER.
 * The function accepts following parameters:
 *  1. INTEGER_ARRAY pontuacao
 *  2. INTEGER tamanho_do_time
 *  3. INTEGER k
 */
function somaPontuacao(array $timeSelecionado){
    return array_sum($timeSelecionado); 
}

function selecionaMelhorPontuacao(array $candidatos, int $k){
    $tamanhoDoArrayCandidatos = count($candidatos);
    
    $primeiroGrupo = array_slice($candidatos,0,$k, true);
    $ultimoGrupo = array_slice($candidatos, -$k, $tamanhoDoArrayCandidatos-1, true);
    
    $maxPrimeiroGrupo = max($primeiroGrupo);
    $maxUltimoGrupo = max($ultimoGrupo);

    return $maxPrimeiroGrupo < $maxUltimoGrupo ? array_search($maxUltimoGrupo, $ultimoGrupo) : array_search($maxPrimeiroGrupo, $primeiroGrupo);
}

function checkRestricoes($pontuacao, $tamanho_do_time, $k)
{   
    $tamanhoArrayPontuacao = count($pontuacao);
    
    $restricoesPontuacao = min($pontuacao)>=1 && max($pontuacao)<= 109? false:true;
    $restricoesTamanhoTime = $tamanho_do_time>=1 && $tamanho_do_time<=$tamanhoArrayPontuacao ? false:true;
    $restricoesTamanhoSegmentosArray = $k>=1 && $k<=$tamanhoArrayPontuacao ? false:true;
    
    return $restricoesPontuacao && $restricoesTamanhoTime && $restricoesTamanhoSegmentosArray;
}

// n = 100000
// $tamanho_do_time = 600
// k = 500

//1<= $pontuacao[i] >= 109
//1<= $tamanho_do_time <= n   
//1<= k <= n   
   
function formacaoDeTime($pontuacao, $tamanho_do_time, $k) {
    $checkRestricao = checkRestricoes($pontuacao, $tamanho_do_time, $k);
    
    if(!$checkRestricao){            
        $timeSelecionado = array();
        $tamanhoTimeSelecionado = count($timeSelecionado);
    
        for($tamanhoTimeSelecionado=0 ; $tamanhoTimeSelecionado < $tamanho_do_time; $tamanhoTimeSelecionado++) {        
            $keyMelhorPontuacao = selecionaMelhorPontuacao($pontuacao, $k);
            $melhorPontuacao = $pontuacao[$keyMelhorPontuacao];
            array_push($timeSelecionado, $melhorPontuacao);
            
            unset($pontuacao[$keyMelhorPontuacao]);
        }
        
        if($tamanhoTimeSelecionado == $tamanho_do_time){
            $somatorio = somaPontuacao($timeSelecionado);
            return $somatorio;
        }else{
            return $pontuacao;
        }
    }
    
}

$fptr = fopen(getenv("OUTPUT_PATH"), "w");

$pontuacao_count = intval(trim(fgets(STDIN)));

$pontuacao = array();

for ($i = 0; $i < $pontuacao_count; $i++) {
    $pontuacao_item = intval(trim(fgets(STDIN)));
    $pontuacao[] = $pontuacao_item;
}

$tamanho_do_time = intval(trim(fgets(STDIN)));

$k = intval(trim(fgets(STDIN)));

$result = formacaoDeTime($pontuacao, $tamanho_do_time, $k);

fwrite($fptr, $result . "\n");

fclose($fptr);
